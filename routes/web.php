<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\ShortURLController::class, 'index']);
Route::resource('shorten-url', \App\Http\Controllers\ShortURLController::class);

Route::get('{url_key}', '\App\Http\Controllers\ShortURLController@shortenUrl')->name('shorten.url');
