<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CategoryRequest;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('photo')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        $categoryStatus = CategoryStatusEnum::labels();
        return view('admin.categories.create', compact('categoryStatus'));
    }
    
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

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
    
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        $items = Item::where('category_id', $id)->paginate(10);
        return view('admin.categories.show', compact('category', 'items'));
    }

    public function edit(string $id)
    {
        $category = Category::FindOrFail($id);
        $categoryStatus = CategoryStatusEnum::labels();
        return view('admin.categories.edit', compact('category', 'categoryStatus'));
    }

    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::FindOrFail($id);
        $category->update($request->validated());

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
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = Category::FindOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
