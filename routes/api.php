<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'getAll']);
Route::patch('/category/{category}', [CategoryController::class, 'update']);

Route::get('/products', [ProductController::class, 'products']);
