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

Route::get('/login', 'App\Http\Controllers\Pages\PagesController@login')->name('login');
Route::get('/register', 'App\Http\Controllers\Pages\PagesController@register')->name('register');
Route::get('/update', 'App\Http\Controllers\Pages\PagesController@update')->name('update');
Route::get('/pokemons', 'App\Http\Controllers\Pages\PagesController@lists')->name('lists');
Route::get('/pokemons/view/{id}', 'App\Http\Controllers\Pages\PagesController@view')->name('view');
Route::get('/pokemons/favorites', 'App\Http\Controllers\Pages\PagesController@lists')->name('lists');
