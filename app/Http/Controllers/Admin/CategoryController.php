<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * CategoryController - Controller لإدارة الفئات
 * 
 * هذا Controller يحتوي على جميع العمليات CRUD للفئات:
 * - Create: إنشاء فئة جديدة
 * - Read: عرض قائمة الفئات وفئة واحدة
 * - Update: تعديل فئة موجودة
 * - Delete: حذف فئة
 * 
 * @author Adham
 * @version 1.0
 */
class CategoryController extends Controller
{
    /**
     * عرض قائمة جميع الفئات (Read - Index)
     * 
     * هذه الدالة تستخدم لعرض جميع الفئات مع:
     * - تحميل الصور المرتبطة بالفئات (Eager Loading)
     * - تقسيم النتائج إلى صفحات (Pagination) - 10 فئات في كل صفحة
     * - إرسال البيانات إلى view المخصص لعرض الفئات
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // جلب جميع الفئات مع الصور المرتبطة بها + تقسيم النتائج
        $categories = Category::with('photo')->paginate(10);
        
        // إرسال البيانات إلى صفحة عرض الفئات
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * عرض نموذج إنشاء فئة جديدة (Create - Form)
     * 
     * هذه الدالة تستخدم لعرض نموذج إنشاء فئة جديدة مع:
     * - جلب جميع حالات الفئة المتاحة (نشط/غير نشط)
     * - إرسال البيانات إلى view المخصص لإنشاء فئة
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // جلب جميع حالات الفئة من الـ Enum (نشط/غير نشط)
        $statuses = CategoryStatusEnum::labels();
        
        // إرسال البيانات إلى صفحة إنشاء فئة جديدة
        return view('admin.categories.create', compact('statuses'));
    }

    /**
     * حفظ فئة جديدة في قاعدة البيانات (Create - Store)
     * 
     * هذه الدالة تستخدم لحفظ فئة جديدة مع:
     * - التحقق من صحة البيانات المرسلة (Validation)
     * - إنشاء الفئة في قاعدة البيانات
     * - رفع الصورة إذا تم اختيار واحدة
     * - حفظ معلومات الصورة في جدول Files
     * - إعادة التوجيه مع رسالة نجاح
     * 
     * @param Request $request البيانات المرسلة من النموذج
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المرسلة
        $request->validate([
            'name' => 'required|string|max:255',        // اسم الفئة مطلوب ونصي وأقصى 255 حرف
            'status' => 'required|integer|in:1,2',      // حالة الفئة مطلوبة ورقم (1 أو 2)
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // الصورة اختيارية وصورة بحد أقصى 2MB
        ]);

        // إنشاء الفئة في قاعدة البيانات
        $category = Category::create([
            'name' => $request->name,        // اسم الفئة
            'status' => $request->status,    // حالة الفئة
        ]);

        // التعامل مع رفع الصورة (اختياري)
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');                    // الحصول على الملف
            $filename = time() . '_' . $file->getClientOriginalName(); // إنشاء اسم فريد للملف
            $file->storeAs('public/categories', $filename);    // حفظ الملف في مجلد categories
            
            // حفظ معلومات الصورة في جدول Files
            $category->photo()->create([
                'usage' => 'category_photo',                   // نوع الاستخدام
                'path' => 'categories/' . $filename,           // مسار الصورة
                'ext' => $file->getClientOriginalExtension(),  // امتداد الملف
            ]);
        }

        // إعادة التوجيه إلى قائمة الفئات مع رسالة نجاح
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * عرض تفاصيل فئة محددة (Read - Show)
     * 
     * هذه الدالة تستخدم لعرض تفاصيل فئة محددة مع:
     * - تحميل الصورة المرتبطة بالفئة
     * - تحميل جميع المنتجات المرتبطة بهذه الفئة
     * - إرسال البيانات إلى view المخصص لعرض تفاصيل الفئة
     * 
     * @param Category $category الفئة المراد عرضها (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        // تحميل الصورة والمنتجات المرتبطة بالفئة
        $category->load(['photo', 'items']);
        
        // إرسال البيانات إلى صفحة عرض تفاصيل الفئة
        return view('admin.categories.show', compact('category'));
    }

    /**
     * عرض نموذج تعديل فئة محددة (Update - Form)
     * 
     * هذه الدالة تستخدم لعرض نموذج تعديل فئة محددة مع:
     * - جلب جميع حالات الفئة المتاحة
     * - إرسال بيانات الفئة الحالية إلى النموذج
     * 
     * @param Category $category الفئة المراد تعديلها
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        // جلب جميع حالات الفئة من الـ Enum
        $statuses = CategoryStatusEnum::labels();
        
        // إرسال بيانات الفئة والحالات إلى صفحة التعديل
        return view('admin.categories.edit', compact('category', 'statuses'));
    }

    /**
     * تحديث فئة محددة في قاعدة البيانات (Update - Store)
     * 
     * هذه الدالة تستخدم لتحديث فئة محددة مع:
     * - التحقق من صحة البيانات المرسلة
     * - تحديث بيانات الفئة في قاعدة البيانات
     * - التعامل مع رفع صورة جديدة (حذف القديمة أولاً)
     * 
     * @param Request $request البيانات المرسلة من النموذج
     * @param Category $category الفئة المراد تحديثها
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        // التحقق من صحة البيانات المرسلة (نفس قواعد الإنشاء)
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:1,2',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // تحديث بيانات الفئة في قاعدة البيانات
        $category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        // التعامل مع رفع صورة جديدة (اختياري)
        if ($request->hasFile('photo')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($category->photo) {
                $category->photo->delete();
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/categories', $filename);
            
            // حفظ معلومات الصورة الجديدة
            $category->photo()->create([
                'usage' => 'category_photo',
                'path' => 'categories/' . $filename,
                'ext' => $file->getClientOriginalExtension(),
            ]);
        }

        // إعادة التوجيه إلى قائمة الفئات مع رسالة نجاح
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * حذف فئة محددة من قاعدة البيانات (Delete)
     * 
     * هذه الدالة تستخدم لحذف فئة محددة مع:
     * - حذف الصورة المرتبطة بالفئة (إن وجدت)
     * - حذف الفئة من قاعدة البيانات
     * - إعادة التوجيه مع رسالة نجاح
     * 
     * @param Category $category الفئة المراد حذفها
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        // حذف الصورة المرتبطة بالفئة إذا كانت موجودة
        if ($category->photo) {
            $category->photo->delete();
        }

        // حذف الفئة من قاعدة البيانات
        $category->delete();

        // إعادة التوجيه إلى قائمة الفئات مع رسالة نجاح
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
