<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('categories', CategoryController::class)->only(['index']);
Route::resource('products', ProductController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth:sanctum');