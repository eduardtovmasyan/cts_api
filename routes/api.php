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
Route::group(['middleware'=>['auth:api']], function()
{
Route::post('/newadmin',"AdminsController@NewAdmin");
Route::post('/showadmin',"AdminsController@ShowAdmin");
Route::post('/deleteadmin',"AdminsController@DeleteAdmin");
Route::post('/updateadmin',"AdminsController@UpdateAdmin");
Route::post('/alladmins',"AdminsController@AllAdmins");
});