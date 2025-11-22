<?php


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\Settings\GeneralSettingsController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ItemController;
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

        Route::resource('units', UnitController::class);
        Route::resource('items', ItemController::class);

        Route::resource('sales', SaleController::class)->only('create', 'store');
        Route::resource('returns', ReturnController::class)->only('create', 'store');

        Route::group(['prefix' => 'settings'], function () {
            Route::get('general', [GeneralSettingsController::class, 'view'])->name('settings.general.view');
            Route::put('general', [GeneralSettingsController::class, 'update'])->name('settings.general.update');
        });
    });
});
