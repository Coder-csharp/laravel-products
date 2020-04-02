<?php

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

//Route::get('/', function () {
   // return view('welcome');
//});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::name('home')->get('/', 'ProductController@index');
Route::name('product')->get('/product/{id}', 'ProductController@product');
Route::name('cart')->get('/cart', 'ProductController@cart');
Route::name('tocart')->post('/tocart', 'ProductController@toCart');
Route::name('clearAll')->post('/clearAll', 'ProductController@clearAll');
Route::name('clear_S')->post('/clear_S', 'ProductController@clear');
Route::name('mailer')->post('/mailer', 'ProductController@mailer');


//Route::name('home')->get('/', 'Each\HomeController@index');
//Route::name('product')->get('/product', 'Each\ProductController@index');
//Route::name('cart')->get('/cart', 'Each\CartController@index');