<?php

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

Route::get('/', 'BetController@index');

Auth::routes();

Route::get('/home', 'WelcomeController@welcome')->name('home');

// Google Logger
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('bets', 'BetController')->except('show');
Route::get('bets/win/{bet}', 'BetController@win')->name('bets.win');
Route::get('bets/lost/{bet}', 'BetController@lost')->name('bets.lost');