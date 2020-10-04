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

Auth::routes();

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/profile', 'ProfileController');

Route::resource('/user', 'UserController');

Route::resource('/category', 'CategoryController');

Route::resource('/feedback', 'FeedbackController');


Route::get('/usuario/novo', function () {
    $user = null;
    return view('users/user', compact('user'));
})->name('novo_usuario');

Route::get('/categoria/novo','CategoryController@novo')->name('categoria_nova');
