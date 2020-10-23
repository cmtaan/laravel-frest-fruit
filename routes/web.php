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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('category', 'categoryController');
Route::resource('user', 'UserController');
Route::post('district/{id}', 'districtController@get_ward');
Route::post('province/{id}', 'provinceController@get_district');
Route::post('editcategory/validation','categoryController@validatededit'); 
Route::post('user/validateedit', 'userController@validate_edit');

// Product
Route::get('product', 'ProductController@index')->name('IndexProduct');
Route::get('product/create', 'ProductController@createProduct')->name('CreateProduct');