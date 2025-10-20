<?php


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::redirect('/', 'admin/home');

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

        // مسار إنشاء عملية بيع (مخصص)
        Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    });
});
