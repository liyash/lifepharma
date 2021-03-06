<?php

use Illuminate\Http\Request;
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

Route::post('/login', 'Api\AuthController@login');
Route::group(['middleware' => ["auth:api"]], function () {
    //
    Route::get('listProducts', "Api\ProductController@listProducts");
    Route::post('addtocart', "Api\OrderController@addToCart");
    Route::post('associateordertransaction', "Api\OrderController@associateOrdertransaction");

    Route::get('listOrders', "Api\OrderController@listOrders");
    Route::get('listOrderById/{id}', "Api\OrderController@listOrderByID");
    Route::get('deleteOrderById/{id}', "Api\OrderController@deleteOrderByID");
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
