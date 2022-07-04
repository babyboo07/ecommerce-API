<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductLoverController;
use App\Http\Controllers\PurchasedProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\ProductLover;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(RoleController::class)->group(function () {
    Route::get('/role', 'index');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/getUserInfo', 'getUserInfo');
    Route::get('/users', 'index');
    Route::post('/users/add', 'create');
    Route::get('/users/delete/{id}', 'destroy');
    Route::get('/users/show/{id}', 'show');
    Route::post('/users/edit/{id}', 'edit');
    Route::post('/users/editpassword/{id}', 'editpassword');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index');
    Route::get('/category/getParentList', 'getParentCate');
    Route::post('/category/add', 'create');
    Route::get('/category/show/{id}', 'show');
    Route::post('/category/edit/{id}', 'edit');
    Route::get('/category/delete/{id}', 'destroy');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index');
    Route::get('/product/detail/{id}', 'show');
    Route::get('/product/delete/{id}', 'destroy');
    Route::get('/product/catelist', 'getCategoryList');
    Route::post('/product/add', 'create');
    Route::post('/product/edit/{id}', 'edit');
});

Route::controller(CartController::class)->group(function () {
    Route::post('/cart/add', 'create');
    Route::get('/cart/show/{id}', 'show');
    Route::get('/cart/destroy/{id}', 'destroy');
    Route::get('/cart/delete/{id}', 'delete');
});

Route::controller(AddressController::class)->group(function () {
    Route::get('/address/{id}', 'show');
    Route::post('/address/add', 'create');
    Route::get('/address/detail/{id}', 'details');
    Route::post('/address/edit/{id}', 'edit');
});

Route::controller(PurchasedProductController::class)->group(function () {
    Route::post('/purchasedProducts/add', 'create');
    Route::get('/purchasedProducts/{id}', 'getall');
    Route::get('/purchasedProducts/userid{userId}/status{status}', 'index');
});

Route::controller(ProductLoverController::class)->group(function () {
    Route::post('/productLovers/add', 'create');
    Route::get('/productLovers/{id}', 'index');
    Route::get('/productLovers/delete/{proLoverId}/{userId}', 'destroy');
});
