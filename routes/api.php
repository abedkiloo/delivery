<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'middleware' => ['api']], function () {

    Route::post('users', 'UserController@store');
    Route::post('login', 'UserController@login');

});

Route::group(['prefix' => 'v1','middleware'=>['delivery_auth']], function () {
//    Route::apiResources(['users', 'UserController']);

    /**
     * products end points
     */
    Route::apiResources(['products' => "ProductsController"]);
    /**
     * orders end points
     */
    Route::apiResources(['orders' => "OrdersController"]);/**
     * suppliers end points
     */
    Route::apiResources(['suppliers' => "SupplierController"]);
    /**
     * supplier-products end points
     */
    Route::apiResources(['supplier-products' => "SupplierProductsController"]);
    /**
     * orders end points
     */
    Route::apiResources(['order-details' => "OrderDetailsController"]);

});
