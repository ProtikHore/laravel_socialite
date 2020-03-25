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

Route::get('/', 'LoginController@index');
Route::post('login', 'LoginController@login')->middleware("throttle:4,1");
Route::get('logout', 'LoginController@logout');

Route::get('user', 'UserController@index')->name('home.index');
Route::get('user/get/social/login/{search_key}', 'UserController@getRecords')->name('home.get.records');

Route::get('login/google', 'LoginController@redirectToGoogle');
Route::get('login/google/callback', 'LoginController@handleGoogleCallback');