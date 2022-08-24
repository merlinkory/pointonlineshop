<?php

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
    return view('welcome');
});

Route::get('/products', [App\Http\Controllers\ProductController::class, 'getProducts'])->middleware('auth');

Route::group(['middleware' => 'admin_auth'], function () {
    Route::view('/admin', 'admin');
    Route::view('/admin/products', 'admin');
    
    Route::get('admin/api/users',[App\Http\Controllers\UserController::class,'getUsers']);
    Route::post('admin/api/users/create_user_point_transaction',[App\Http\Controllers\UserController::class,'makeUserPointTransaction']);
    Route::post('admin/api/products', [App\Http\Controllers\ProductController::class, 'newProduct']);

});
  

    
Route::name('user.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\LoginController::class,'index'])->name('login');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
    Route::get('/logout', [\App\Http\Controllers\LoginController::class,'logout']);
    Route::view('/lk', 'lk')->middleware('auth')->name('lk');
    Route::view('/lk/cart', 'lk')->middleware('auth')->name('lk');
    Route::view('/lk/about', 'lk')->middleware('auth')->name('lk');
    Route::get('/registration', [\App\Http\Controllers\RegistrationController::class,'index'])->name('registration');
    Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'save']);
});

