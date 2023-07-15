<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get("/categories", [CategoryController::class, 'index']);
Route::get("/category/create", [CategoryController::class, 'create']);
Route::post("/category/store", [CategoryController::class, 'store']);
Route::get("/category/edit/{id}", [CategoryController::class, 'edit']);
Route::post("/category/update/{id}", [CategoryController::class, 'update']);
Route::post("/category/delete/{id}", [CategoryController::class, 'destroy']);

Route::get("/product", [ProductController::class, 'index']);
Route::get("/product/create", [ProductController::class, 'create']);
Route::post("/product/store", [ProductController::class, 'store']);
Route::get("/product/edit/{id}", [ProductController::class, 'edit']);
Route::post("/product/update/{id}", [ProductController::class, 'update']);
Route::post("/product/delete/{id}", [ProductController::class, 'destroy']);
