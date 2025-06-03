<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\BlogCollectionController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PageHomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthenticationController::class, 'index'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [AuthenticationController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/filter', [AuthenticationController::class, 'filterDashboard']);

    Route::resource('pagehomes', PageHomeController::class);
    Route::get('woman', [PageHomeController::class, 'woman'])->name('pagehomes.woman');

    Route::resource('categories', CategoryController::class);

    Route::resource('colors', ColorController::class);

    Route::resource('collections', CollectionController::class);

    Route::resource('products', ProductController::class);
    Route::put('products/{product}/status', [ProductController::class, 'status'])->name('products.status');

    Route::resource('blogcollections', BlogCollectionController::class);

    Route::resource('campaigns', CampaignController::class);

    Route::resource('vouchers', VoucherController::class);
    Route::put('vouchers/{voucher}/status', [VoucherController::class, 'status'])->name('vouchers.status');

    Route::resource('locations', LocationController::class);

    Route::resource('orders', OrderController::class);
});
