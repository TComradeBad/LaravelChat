<?php

use App\Http\Controllers\RegisterApiController;
use App\Http\Middleware\IsRegistered;
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
Route::any("/register","RegisterApiController@register")->middleware(IsRegistered::class);

Route::any("/login","RegisterApiController@login");

Route::any("/msg","RegisterApiController@msg_test");

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
