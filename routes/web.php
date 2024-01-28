<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Permission;
use Illuminate\Support\Facades\Route;

//users

//Route::group(['middleware'=>'Permission:admin'],function (){

Route::post('user/fillter',[UserController::class ,'filter'])->name('user.fillter');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::any('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

//factor

Route::get('/check/create', [checkController::class, 'create'])->name('check.create');
Route::get('/check/index', [checkController::class, 'index'])->name('check.index');
Route::any('/check/store', [checkController::class, 'store'])->name('check.store');
Route::get('/check/{id}/edit', [checkController::class, 'edit'])->name('check.edit');
Route::patch('/check/{id}', [checkController::class, 'update'])->name('check.update');
Route::delete('/check/{id}/delete', [checkController::class, 'destroy'])->name('check.destroy');

//});
//products
Route::group(['middleware'=>'Permission:adminAndseller','prefix'=>'products'],function (){

Route::get('/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::patch('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});
//orders

Route::group(['middleware'=>'checkrole:adminAndcustomer' , 'prefix'=>'orders'],function (){

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

});
/////login

Route::view('/login', 'authorize.login')->name('login');

Route::view('/register', 'authorize.register')->name('register');

Route::get('/workplace', function () {
    return view('workplace');
})->name('workplace')->middleware('auth:sanctum');


Route::post('auth/register', [AuthController::class, 'UserRegister'])->name('registerUser');
Route::any('auth/login', [AuthController::class, 'loginUser'])->name('loginUser');
Route::get('auth/logout', [AuthController::class, 'logoutUser'])->name('logoutuser')->middleware('auth:sanctum');


//});
