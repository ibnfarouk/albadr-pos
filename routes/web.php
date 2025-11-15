<?php

use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\Settings\GeneralSettingsController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'admin/home');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Auth::routes(['register' => false]);

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        Route::resource('units', UnitController::class);
        Route::resource('items', ItemController::class);

        Route::resource('sales', SaleController::class)->only('create', 'store');

        Route::group(['prefix' => 'settings'], function () {
            Route::get('general', [GeneralSettingsController::class, 'view'])->name('settings.general.view');
            Route::put('general', [GeneralSettingsController::class, 'update'])->name('settings.general.update');
        });
    });
});
