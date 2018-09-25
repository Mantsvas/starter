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

Route::get('/', 'WelcomeController@welcome');

Auth::routes();

Route::get('/home', 'PlayerController@index')->name('home');

// Google Logger
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('posts','PostController');
Route::resource('categories','CategoryController');

Route::get('/players', 'PlayerController@index')->name('players.index');
Route::get('/players/sort', 'PlayerController@playersSort')->name('players.sort');
Route::get('/players/create', 'PlayerController@create')->name('players.create')->middleware('admin');
Route::post('/players', 'PlayerController@store')->name('players.store');
Route::get('/players/updateall', 'PlayerController@updateAll')->name('players.updateAll')->middleware('admin');
Route::get('/players/{player}', 'PlayerController@show')->name('players.show');
Route::get('/players/{player}/edit', 'PlayerController@edit')->name('players.edit')->middleware('admin');
Route::get('/players/update/{player}', 'PlayerController@update')->name('players.update');
Route::delete('/players/{player}', 'PlayerController@destroy')->name('players.destroy')->middleware('admin');
Route::get('/players/kick/{player}', 'PlayerController@kickPlayerFromClan')->name('players.kick')->middleware('admin');
Route::get('/players/add/{player}', 'PlayerController@addPlayerToClan')->name('players.addToClan')->middleware('admin');

Route::get('/wars', 'WarController@index')->name('wars.index');
Route::get('/wars/create', 'WarController@create')->name('wars.create')->middleware('admin');
Route::post('/wars', 'WarController@store')->name('wars.store')->middleware('admin');
Route::get('/wars/{war}', 'WarController@show')->name('wars.show');
Route::get('/wars/{war}/edit', 'WarController@edit')->name('wars.edit')->middleware('admin');
Route::put('/wars/{war}', 'WarController@update')->name('wars.update')->middleware('admin');
Route::delete('/wars/{war}', 'WarController@destroy')->name('wars.destroy')->middleware('admin');

Route::get('/tournaments', 'TournamentController@index')->name('tournaments.index');
Route::get('/tournaments/create', 'TournamentController@create')->name('tournaments.create')->middleware('tournamentModerator');
Route::post('/tournaments', 'TournamentController@store')->name('tournaments.store')->middleware('tournamentModerator');
Route::get('/tournaments/rules', 'TournamentController@rules')->name('tournaments.rules');
Route::get('/tournaments/{tournament}', 'TournamentController@show')->name('tournaments.show');
Route::get('/tournaments/{tournament}/edit', 'TournamentController@edit')->name('tournaments.edit')->middleware('tournamentModerator');
Route::put('/tournaments/{tournament}', 'TournamentController@update')->name('tournaments.update')->middleware('tournamentModerator');
Route::delete('/tournaments/{tournament}', 'TournamentController@destroy')->name('tournaments.destroy')->middleware('admin');
Route::get('/tournaments/{tournament}/start', 'TournamentController@startTournament')->name('tournaments.startTournament')->middleware('tournamentModerator');
Route::put('/battle/{battle}', 'TournamentController@storeBattleResult')->name('battles.store')->middleware('tournamentModerator');


Route::post('/tournamentPlayer','TournamentPlayerController@store')->name('tournamentPlayer.store');
Route::delete('/tournamentPlayer/{player}','TournamentPlayerController@destroy')->name('tournamentPlayer.destroy');

Route::get('cards','CardController@index')->name('cards.index');
Route::get('cards/{{card}}','CardController@show')->name('cards.show');
Route::get('cards/update','CardController@updateCardList')->name('cards.update')->middleware('admin');

Route::get('c/{player}','PlayerController@calculateGold');
