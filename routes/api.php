<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('district/{id}', 'districtController@get_ward');
Route::post('province/{id}', 'provinceController@get_district');
Route::post('editcategory/validation','categoryController@validatededit'); 
Route::post('user/validateedit', 'userController@validate_edit');
Route::delete('category/{id}', 'categoryController@destroy');


// Product API
Route::get('product', 'ProductController@getProducts');