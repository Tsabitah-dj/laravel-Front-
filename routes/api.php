<?php

use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\OrdersController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{id}', [ProductsController::class, 'show']);

Route::get('/orders', [OrdersController::class, 'index']);
Route::post('/orders', [OrdersController::class, 'store']);