<?php

use App\Models\tb_user;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login-api','App\Http\Controllers\androidAPIController@loginAPI');
Route::post('/register-api','App\Http\Controllers\androidAPIController@registerAPI');
Route::get('/test-data', function (){
    return new \App\Http\Resources\tb_user(tb_user::find(1));
});
Route::post('/add-project-api','App\Http\Controllers\androidAPIController@addProject');
Route::get('/get-project','App\Http\Controllers\androidAPIController@getProject');
