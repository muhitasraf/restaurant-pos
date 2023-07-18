<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
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

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'porcessLogin']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/', function () {
        return view('index');
    })->name('home');

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
    Route::put("/product/update/{id}", [ProductController::class, 'update']);
    Route::get("/product/delete/{id}", [ProductController::class, 'destroy']);

    Route::get("/tables", [TableController::class, 'index']);
    Route::get("/table/create", [TableController::class, 'create']);
    Route::post("/table/store", [TableController::class, 'store']);
    Route::get("/table/edit/{id}", [TableController::class, 'edit']);
    Route::put("/table/update/{id}", [TableController::class, 'update']);
    Route::get("/table/delete/{id}", [TableController::class, 'destroy']);

    Route::get("/sales", [SalesController::class, 'index']);
    Route::get("/sales/create", [SalesController::class, 'create']);
    Route::post("/sales/store", [SalesController::class, 'store']);
    Route::get("/sales/edit/{id}", [SalesController::class, 'edit']);
    Route::put("/sales/update/{id}", [SalesController::class, 'update']);
    Route::get("/sales/delete/{id}", [SalesController::class, 'destroy']);

    Route::get("/product_from_cart", [SalesController::class, 'product_from_cart']);
    Route::post("/add_to_cart", [SalesController::class, 'add_to_cart']);
    Route::post("/delete_from_cart", [SalesController::class, 'delete_from_cart']);
    Route::post("/cancle_order", [SalesController::class, 'cancle_order']);

    Route::get("/expenses", [ExpenseController::class, 'index']);
    Route::get("/expense/create", [ExpenseController::class, 'create']);
    Route::post("/expense/store", [ExpenseController::class, 'store']);
    Route::get("/expense/edit/{id}", [ExpenseController::class, 'edit']);
    Route::put("/expense/update/{id}", [ExpenseController::class, 'update']);
    Route::get("/expense/delete/{id}", [ExpenseController::class, 'destroy']);

    Route::get("/daily_sales", [SalesController::class, 'daily_sales'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/daily_sales_result", [SalesController::class, 'daily_sales_result'])->middleware(['admin_level_access', 'account_validity']);

    Route::get("/monthly_sales", [SalesController::class, 'monthly_sales'])->middleware(['admin_level_access', 'account_validity']);
    Route::post("/monthly_sales_result", [SalesController::class, 'monthly_sales_result'])->middleware(['admin_level_access', 'account_validity']);
});
