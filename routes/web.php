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

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['role_check', 'auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);

    // Order routes
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', 'OrderController@index')->name('list.orders');
        Route::get('/create', 'OrderController@create')->name('create.order');
        Route::post('/store', 'OrderController@store')->name('store.order');
        Route::get('/{id}/destroy', 'OrderController@destroy')->name('destroy.order');
    });
});




Route::get('/about', function () {
    return view('about');
})->name('about');
