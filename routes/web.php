<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Ramsey\Uuid\Type\Integer;

Route::get('/', function () {
    return Inertia::render('Main');
});

Route::get('/products/{id}', function (int $id) {
    return Inertia::render('ShowProduct', ['id' => $id]);
});