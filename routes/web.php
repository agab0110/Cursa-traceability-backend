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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/password/setup', 'App\Http\Controllers\PasswordResetController@showPasswordSetupForm')->name('password.setup');
Route::post('/password/setup', 'App\Http\Controllers\PasswordResetController@update')->name('passoword.update');
Route::get('/class-docs', function () {
    return view('classDocs');
});
