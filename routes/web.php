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

// Index
Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);

// Authentication
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('/login', ['as' => 'login-post', 'uses' => 'Auth\LoginController@login']);
Route::post('/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Invite
Route::prefix('/invite')->group(function () {
    Route::get('/{token}', ['as' => 'invite', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);
});

// Testing
Route::get('tmdb', ['as' => 'tmdb', 'uses' => 'TmdbController@index']);

Route::middleware(['auth', 'permission:viewAdmin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

});
