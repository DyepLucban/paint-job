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

Route::post('/process', 'PaintJobController@store');
Route::get('/cars', 'PaintJobController@getAllCars');
Route::put('/queue/{id}', 'PaintJobController@update');
Route::get('/count', 'PaintJobController@countOnProgress');
Route::get('/totals', 'PaintJobController@getTotals');
