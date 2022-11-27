<?php

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

Route::post('/user/authenticate', 'App\Http\Controllers\API\UserController@authenticate');
Route::post('/user/register', 'App\Http\Controllers\API\UserController@register');
Route::post('/user/update', 'App\Http\Controllers\API\UserController@update');
Route::post('/user/detail', 'App\Http\Controllers\API\UserController@detail');

Route::get('/user/pokemons', 'App\Http\Controllers\API\PokemonsController@list');
Route::get('/user/pokemons/view/{slack}', 'App\Http\Controllers\API\PokemonsController@view');
Route::post('/user/pokemons/favorite', 'App\Http\Controllers\API\PokemonsController@favorite');
Route::post('/user/pokemons/validation', 'App\Http\Controllers\API\PokemonsController@validation');
