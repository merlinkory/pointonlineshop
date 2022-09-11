<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;
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

Route::get('/test',function(){
    $order = Order::create([
        "first_name" => "Maxim",
    ]);
});

Route::get('/', function () {
    return view('welcome');
});

//for Cleent Area
Route::get('/products', [App\Http\Controllers\ProductController::class, 'get'])->middleware('auth');
Route::post('/order',[\App\Http\Controllers\OrderController::class,'save'])->middleware('auth');
Route::get('/order',[\App\Http\Controllers\OrderController::class,'get'])->middleware('auth');

Route::group(['middleware' => 'admin_auth'], function () {
    Route::view('/admin', 'admin');
    Route::view('/admin/products', 'admin');

    Route::get('admin/api/users',[App\Http\Controllers\UserController::class,'getUsers']);
    Route::post('admin/api/users/create_user_point_transaction',[App\Http\Controllers\UserController::class,'makeUserPointTransaction']);
    Route::post('admin/api/product', [App\Http\Controllers\ProductController::class, 'save']);
    Route::put('admin/api/product', [App\Http\Controllers\ProductController::class, 'update']);
    Route::delete('admin/api/product/{id}', [App\Http\Controllers\ProductController::class, 'delete']);
    Route::delete('admin/api/product/image/{id}', [App\Http\Controllers\ProductController::class, 'deleteImage']);
    Route::post('admin/api/product/image', [App\Http\Controllers\ProductController::class, 'saveImage']);

});



Route::name('user.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\LoginController::class,'index'])->name('login');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
    Route::get('/logout', [\App\Http\Controllers\LoginController::class,'logout']);
    Route::view('/lk', 'lk')->middleware('auth')->name('lk');
    Route::view('/lk/cart', 'lk')->middleware('auth')->name('lk');
    Route::view('/lk/orders', 'lk')->middleware('auth')->name('lk');
    Route::get('/registration', [\App\Http\Controllers\RegistrationController::class,'index'])->name('registration');
    Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'save']);
});

