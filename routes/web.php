<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'admin/home');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Auth::routes(['register' => false]);

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
    });
});
