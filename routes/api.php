<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', 'App\Http\Controllers\UserController@register');
Route::post('/login', 'App\Http\Controllers\UserController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('produk/create', 'App\Http\Controllers\ProdukController@store');
    Route::get('produk/getall', 'App\Http\Controllers\ProdukController@index');
    Route::get('produk/getall/{id}', 'App\Http\Controllers\ProdukController@indexspecific');
    Route::put('produk/update/{id}', 'App\Http\Controllers\ProdukController@update');
    Route::delete('produk/delete/{id}', 'App\Http\Controllers\ProdukController@destroy');

    Route::post('/logout', 'App\Http\Controllers\UserController@logout');
});
