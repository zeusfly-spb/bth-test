<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Main');
});

Route::get('/products/{id}', function (int $id) {
    return Inertia::render('ShowProduct', ['id' => $id]);
});

Route::get('/admin', function () {
    return Inertia::render('Admin');
});

Route::get('/login', function () {
    return Inertia::render('Login');
});

Route::get('/admin/products/{id}/edit', function(int $id) {
    return Inertia::render('EditProduct', ['id' => $id]);
});

Route::get('/admin/products/create', function() {
    return Inertia::render('CreateProduct');
});