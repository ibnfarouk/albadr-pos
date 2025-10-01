<?php

/**
 * ملف Routes الرئيسي للتطبيق
 * 
 * هذا الملف يحتوي على جميع المسارات (Routes) الخاصة بالتطبيق:
 * - مسارات المصادقة (Authentication)
 * - مسارات لوحة التحكم (Admin Panel)
 * - مسارات CRUD للفئات والمنتجات
 * 
 * @author Adham
 * @version 1.0
 */

// استيراد Controllers المطلوبة
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// إعادة التوجيه من الصفحة الرئيسية إلى لوحة التحكم
Route::redirect('/', 'admin/home');

// مجموعة المسارات الخاصة بلوحة التحكم (Admin Panel)
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // مسارات المصادقة (تسجيل دخول/خروج) - بدون تسجيل مستخدم جديد
    Auth::routes(['register' => false]);

    // مجموعة المسارات المحمية (تتطلب تسجيل دخول)
    Route::group(['middleware' => 'auth'], function () {
        
        // الصفحة الرئيسية للوحة التحكم
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        
        // مسارات CRUD للمستخدمين
        Route::resource('users', UserController::class);
        
        // مسارات CRUD للفئات (Categories) - النظام الجديد
        Route::resource('categories', CategoryController::class);
        // هذا السطر ينشئ تلقائياً المسارات التالية:
        // GET    /admin/categories           (index)   - عرض قائمة الفئات
        // GET    /admin/categories/create    (create)  - نموذج إنشاء فئة
        // POST   /admin/categories           (store)   - حفظ فئة جديدة
        // GET    /admin/categories/{id}      (show)    - عرض تفاصيل فئة
        // GET    /admin/categories/{id}/edit (edit)    - نموذج تعديل فئة
        // PUT    /admin/categories/{id}      (update)  - تحديث فئة
        // DELETE /admin/categories/{id}      (destroy) - حذف فئة

        // مسار إنشاء عملية بيع (مخصص)
        Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    });
});
