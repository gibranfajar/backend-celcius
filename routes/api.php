<?php

use App\Http\Controllers\API\APIController;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RajaOngkirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('pagehomes', [APIController::class, 'pagehomes']);

Route::get('categories', [APIController::class, 'categories']);

Route::get('collections', [APIController::class, 'collections']);
Route::get('collections/{slug}', [APIController::class, 'collectionsDetail']);

Route::get('blogcollections', [APIController::class, 'blogcollections']);

Route::get('campaigns', [APIController::class, 'campaigns']);
Route::get('campaigns/{slug}', [APIController::class, 'campaignDetail']);

Route::get('products', [ProductController::class, 'index']);

Route::get('vouchers', [APIController::class, 'vouchers']);

Route::get('locations', [APIController::class, 'locations']);

// register
Route::post('register', [AuthenticationController::class, 'register']);

// login
Route::post('login', [AuthenticationController::class, 'login']);

// rajaongkir
Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'getCities']);
Route::get('/subdistricts/{cityId}', [RajaOngkirController::class, 'getSubdistricts']);
Route::post('/cost', [RajaOngkirController::class, 'getCost']);
Route::post('/track', [RajaOngkirController::class, 'trackShipment']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('cart', [CartController::class, 'show']);
    Route::post('cart', [CartController::class, 'store']);
    Route::delete('cart/{cart}', [CartController::class, 'destroy']);

    // process payment atau checkout
    Route::post('checkout', [OrderController::class, 'createTransaction']);

    // list transaction
    Route::get('transactions', [OrderController::class, 'transactionList']);
    Route::get('transactions/{id}', [OrderController::class, 'transactionDetail']);
});

Route::post('callback', [OrderController::class, 'updatePaymentStatus']);
