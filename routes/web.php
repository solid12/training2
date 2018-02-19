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

Route::get('/', 'IndexController@index');
Route::get('/index', 'IndexController@index');
Route::get('/cart', 'IndexController@cart');
Route::post('/cart', 'IndexController@cart');
Route::get('/login', 'LoginController@login');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');
Route::get('/products', 'ProductController@products');
Route::get('/delete', 'ProductController@delete');
Route::get('/product', 'ProductController@product');
Route::post('/product', 'ProductController@product');

