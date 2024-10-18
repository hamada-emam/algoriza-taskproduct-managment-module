<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Support\Facades\Route;


// Dashboard Routes
Route::middleware(['auth', 'web'])->prefix('dashboard')->group(function () {

    Route::get('/', [ProductController::class, 'list'])->name('products.list');
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products/store', 'store')->name('products.store');
        Route::get('/products/{id}/edit', 'edit')->name('products.edit');
        Route::put('/products/{id}/update', 'update')->name('products.update');
        Route::delete('/{id}/delete', 'delete')->name('products.delete');
    });

    // Route::controller(CategoryController::class)->group(['prefix' => 'products'], function () {
    //     Route::post('/', 'create')->name('categories.create');
    //     Route::put('/', 'store')->name('categories.store');
    //     Route::post('/{id}/edit', 'edit')->name('categories.edit');
    //     Route::put('/{id}/update', 'update')->name('categories.update');
    //     Route::delete('/{id}/delete', 'delete')->name('categories.delete');
    // });

    // Route::resource('roles', RoleController::class);
    // Route::resource('permissions', PermissionController::class);
    // Route::resource('users', UserController::class);
});

// Authentication routes
Route::controller(AuthenticationController::class)->middleware(['web'])->group(function () {
    Route::get('login', 'loginForm')->name('login.form');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

// Guest Routes
Route::get('/', [ProductController::class, 'index'])->name('guest.products');
Route::get('/{id}', [ProductController::class, 'view'])->name('guest.product');
