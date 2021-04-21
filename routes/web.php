<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','App\Http\Controllers\DefaultController@index');
Route::get('/allData','App\Http\Controllers\DefaultController@allData');
Route::get('/editData/{id}','App\Http\Controllers\DefaultController@editData');
Route::post('data/store','App\Http\Controllers\DefaultController@dataStore');
Route::post('data/update/{id}','App\Http\Controllers\DefaultController@dataUpdate');
Route::get('/data/delete/{id}','App\Http\Controllers\DefaultController@delete');

