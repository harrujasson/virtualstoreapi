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

Route::group(['prefix' => 'v1','middleware' => ['keycheck']], function () {
    Route::group(['prefix'=>'product','as'=>'product.'],function(){
        Route::get('all',['uses'=>"App\Http\Controllers\Api\ProductController@product_all"]);
        Route::post('category',['uses'=>"App\Http\Controllers\Api\ProductController@product_category"]);
        Route::post('single',['uses'=>"App\Http\Controllers\Api\ProductController@product_single"]);
    });
    Route::group(['prefix'=>'category','as'=>'category.'],function(){
        Route::get('all',['uses'=>"App\Http\Controllers\Api\CategoryController@all"]);
        Route::post('single',['uses'=>"App\Http\Controllers\Api\CategoryController@single"]);
    });
    Route::group(['prefix'=>'orders','as'=>'orders.'],function(){
        Route::get('all',['uses'=>"App\Http\Controllers\Api\OrderController@all"]);        
        Route::post('single',['uses'=>"App\Http\Controllers\Api\OrderController@single"]);
        Route::post('create',['uses'=>"App\Http\Controllers\Api\OrderController@create"]);
        Route::post('payment-verify',['uses'=>"App\Http\Controllers\Api\OrderController@payment_verify"]);
    });
    Route::post('store-register',['uses'=>"App\Http\Controllers\Api\CommonController@store_register"]);
    
});