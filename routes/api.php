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
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['auth:api']], function()
{
Route::post('/newadmin','UserController@newAdmin');
Route::post('/showadmin','UserController@showAdmin');
Route::post('/deleteadmin','UserController@deleteAdmin');
Route::post('/updateadmin','UserController@updateAdmin');
Route::post('/alladmins','UserController@allAdmins');
});