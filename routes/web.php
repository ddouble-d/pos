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

Auth::routes();

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/setting', 'SettingController@index')->name('setting.index');
    Route::post('/setting', 'SettingController@store')->name('setting.store');
    Route::resource('produk', 'ProdukController');
    Route::resource('customer', 'CustomerController');
    Route::resource('orders', 'OrderController');

    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::post('/cart', 'CartController@store')->name('cart.store');
    Route::post('/cart/change-qty', 'CartController@changeQty');
    Route::delete('/cart/delete', 'CartController@delete');
    Route::delete('/cart/empty', 'CartController@empty');

    Route::get('/order', 'OrderController@index')->name('order.index');
});
