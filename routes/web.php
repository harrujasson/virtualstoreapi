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

Auth::routes();

Route::post('login',['as'=>"login",'uses'=>"App\Http\Controllers\Auth\LoginController@login"]);
Route::post('register',['as'=>"register",'uses'=>"App\Http\Controllers\Auth\RegisterController@create"]);
Route::post('front-login',['as'=>"login_front",'uses'=>"Auth\LoginController@login_front"]);
/****Front Routes */
Route::get('/',['as'=>'home','uses'=>"App\Http\Controllers\HomeController@index"]);
Route::get('shop',['as'=>'shop','uses'=>'App\Http\Controllers\ShopController@shop']);
Route::get('product-category/{slug}',['as'=>'category','uses'=>'App\Http\Controllers\ShopController@category_list']);
Route::get('product/{slug}',['as'=>'product_show','uses'=>'App\Http\Controllers\ShopController@details']);
Route::post('review',['as'=>'review','uses'=>'App\Http\Controllers\ShopController@review']);
Route::post('cart-add/{slug}',['as'=>'cart_add','uses'=>'App\Http\Controllers\ShopController@cart_add_details']);
Route::get('cart',['as'=>'cart_list','uses'=>'App\Http\Controllers\ShopController@cart_list']);
Route::post('cart-update',['as'=>'cart_update','uses'=>'App\Http\Controllers\ShopController@cart_item_update']);
Route::get('cart-remove/{rowid}',['as'=>'cart_list_remove','uses'=>'App\Http\Controllers\ShopController@cart_item_remove']);
Route::get('checkout',['as'=>'checkout','uses'=>'App\Http\Controllers\ShopController@checkout']);
Route::post('order-submit',['as'=>'order_submit','uses'=>'App\Http\Controllers\ShopController@order_generate']);
Route::get('order-success/{id}',['as'=>'order_success_offline','uses'=>'ShopController@order_success']);
Route::get('order-fail',['as'=>'order_fail','uses'=>'App\Http\Controllers\ShopController@order_fail']);
Route::get('cart-remove',['as'=>'cart_remove','uses'=>'App\Http\Controllers\ShopController@cart_remove']);
Route::post('product-payment-response','App\Http\Controllers\ShopController@payment_response')->name('product_payment_response');
Route::get('order-payment-success','App\Http\Controllers\ShopController@order_success')->name('order_success');;
Route::get('order-payment-fail','App\Http\Controllers\ShopController@order_fail')->name('order_fail');

Route::get('wishlist-add/{slug}', ['as'=>'wishlist_add','middleware'=>['auth','client'], 'uses'=>'App\Http\Controllers\Customer\HomeController@add_wishlist']);
Route::get('wishlist-add-ajax/{slug}', ['as'=>'wishlist_add','middleware'=>['auth','client'], 'uses'=>'App\Http\Controllers\Customer\HomeController@add_wishlist_ajax']);

Route::group(['prefix'=>'payment','as'=>'payment.'],function(){

    
    Route::get('beep-payment-process/{order_id}',['as'=>'beep_process','uses'=>'App\Http\Controllers\PaymentController@beep_payment']);
    Route::get('beep-payment-response',['as'=>'beep_payment_response','uses'=>'App\Http\Controllers\PaymentController@beep_payment_method_response']);
    
    Route::get('payment-cancel',['as'=>'payment_cancel','uses'=>'App\Http\Controllers\PaymentController@transaction_cancel']);
    Route::get('payment-success/{id}',['as'=>'payment_success','uses'=>'App\Http\Controllers\PaymentController@success']);
});
Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware'=>['auth','admin']], function () {

    Route::get('home', ['as'=>'home', 'uses'=>'App\Http\Controllers\Admin\HomeController@index']);
    Route::get('my-porfile', ['as'=>'my_profile', 'uses'=>'App\Http\Controllers\Admin\HomeController@profile']);
    Route::post('my-profile', ['as'=>'my_profile_save', 'uses'=>'App\Http\Controllers\Admin\HomeController@my_profile_save']);

    Route::get('config', ['as'=>'config', 'uses'=>'App\Http\Controllers\Admin\HomeController@config']);
    Route::post('config-save', ['as'=>'config_save', 'uses'=>'App\Http\Controllers\Admin\HomeController@config_save']);

     /*Users*/
     Route::group(['prefix'=>'users','as'=>'user.'],function(){
        Route::get('create',['as'=>'new_user','uses'=>'App\Http\Controllers\Admin\UserController@create']);
        Route::post('create',['as'=>'create','uses'=>'App\Http\Controllers\Admin\UserController@store']);

        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\UserController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\UserController@showList']);
        Route::get('edit/{id}',['as'=>'edit','uses'=>'App\Http\Controllers\Admin\UserController@edit']);
        Route::post('edit/{id}',['as'=>'edit_save','uses'=>'App\Http\Controllers\Admin\UserController@update']);
        Route::get('delete/{id}',['as'=>'delete','uses'=>'App\Http\Controllers\Admin\UserController@delete']);
    });
     /*Category*/
    Route::group(['prefix'=>'category','as'=>'category.'],function(){
        Route::get('add-new',['as'=>'add_new','uses'=>'App\Http\Controllers\Admin\CategoryController@create']);
        Route::post('add-new',['as'=>'create','uses'=>'App\Http\Controllers\Admin\CategoryController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\CategoryController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\CategoryController@showList']);
        Route::get('edit/{id}',['as'=>'editForm','uses'=>'App\Http\Controllers\Admin\CategoryController@edit']);
        Route::post('edit/{id}',['as'=>'edit_update','uses'=>'App\Http\Controllers\Admin\CategoryController@update']);
        Route::get('deleteAjax/{id}',['as'=>'deleteAjax','uses'=>'App\Http\Controllers\Admin\CategoryController@delete']);

    });
    /*Attribute*/
    Route::group(['prefix'=>'attribute','as'=>'attribute.'],function(){
        Route::get('add-new',['as'=>'add_new','uses'=>'App\Http\Controllers\Admin\AttributeController@create']);
        Route::post('add-new',['as'=>'create','uses'=>'App\Http\Controllers\Admin\AttributeController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\AttributeController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\AttributeController@showList']);
        Route::get('edit/{id}',['as'=>'editForm','uses'=>'App\Http\Controllers\Admin\AttributeController@edit']);
        Route::post('edit/{id}',['as'=>'edit_update','uses'=>'App\Http\Controllers\Admin\AttributeController@update']);
        Route::get('deleteAjax/{id}',['as'=>'deleteAjax','uses'=>'App\Http\Controllers\Admin\AttributeController@delete']);
    });
    /*Product*/
    Route::group(['prefix'=>'product','as'=>'product.'],function(){
        Route::get('add-new',['as'=>'add_new','uses'=>'App\Http\Controllers\Admin\ProductController@create']);
        Route::post('add-new',['as'=>'create','uses'=>'App\Http\Controllers\Admin\ProductController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\ProductController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\ProductController@showList']);
        Route::get('edit/{id}',['as'=>'editForm','uses'=>'App\Http\Controllers\Admin\ProductController@edit']);
        Route::post('edit/{id}',['as'=>'edit_update','uses'=>'App\Http\Controllers\Admin\ProductController@update']);
        Route::get('deleteAjax/{id}',['as'=>'deleteAjax','uses'=>'App\Http\Controllers\Admin\ProductController@delete']);
        Route::get('publish-review/{id}/{approve}',['as'=>'publish_review','uses'=>'App\Http\Controllers\Admin\ProductController@publish']);

        /*Attribute load*/
        Route::post('attribute-load',['as'=>'attribute_load','uses'=>'Admin\ProductController@attribute_load']);
        Route::post('attribute-load-edit',['as'=>'attribute_load_edit','uses'=>'Admin\ProductController@attribute_load_exist']);
        Route::post('import-product',['as'=>'import_product','uses'=>'Admin\ProductController@import_product']);
        Route::get('import-product-gallery/{filename}',['as'=>'import_product_gallery','uses'=>'Admin\ProductController@import_product_gallery']);

        Route::get('import-product',['as'=>'import_product_get','uses'=>'Admin\ProductController@import_product']);
    });

    /*Tax*/
    Route::group(['prefix'=>'tax','as'=>'tax.'],function(){
        Route::get('add-new',['as'=>'add_new','uses'=>'App\Http\Controllers\Admin\TaxController@create']);
        Route::post('add-new',['as'=>'create','uses'=>'App\Http\Controllers\Admin\TaxController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\TaxController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\TaxController@showList']);
        Route::get('edit/{id}',['as'=>'editForm','uses'=>'App\Http\Controllers\Admin\TaxController@edit']);
        Route::post('edit/{id}',['as'=>'edit_update','uses'=>'App\Http\Controllers\Admin\TaxController@update']);
        Route::get('deleteAjax/{id}',['as'=>'deleteAjax','uses'=>'App\Http\Controllers\Admin\TaxController@delete']);
    });

    /*Orders*/
    Route::group(['prefix'=>'orders','as'=>'orders.'],function(){
        Route::get('show',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\OrdersController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\OrdersController@showList']);
        Route::get('view/{id}',['as'=>'show_full','uses'=>'App\Http\Controllers\Admin\OrdersController@view']);
        Route::post('view/{id}',['as'=>'update','uses'=>'App\Http\Controllers\Admin\OrdersController@update']);
        Route::get('deleteAjax/{id}',['as'=>'deleteAjax','uses'=>'App\Http\Controllers\Admin\OrdersController@delete']);
        Route::post('information-ajax',['as'=>'information','uses'=>'App\Http\Controllers\Admin\OrdersController@information']);

        Route::post('track-order/{id}',['as'=>'track_order','uses'=>'App\Http\Controllers\Admin\OrdersController@track_order']);
        Route::get('export-report',['as'=>'export','uses'=>'App\Http\Controllers\Admin\OrdersController@export']);
    });
    /*Home SLider*/
    Route::group(['prefix'=>'slider','as'=>'slider.'],function(){
        Route::get('add-new',['as'=>'add_new','uses'=>'App\Http\Controllers\Admin\SliderController@create']);
        Route::post('add-new',['as'=>'create','uses'=>'App\Http\Controllers\Admin\SliderController@store']);
        Route::get('manage',['as'=>'manage','uses'=>'App\Http\Controllers\Admin\SliderController@show']);
        Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Admin\SliderController@showList']);
        Route::get('edit/{id}',['as'=>'editForm','uses'=>'App\Http\Controllers\Admin\SliderController@edit']);
        Route::post('edit/{id}',['as'=>'edit_update','uses'=>'App\Http\Controllers\Admin\SliderController@update']);
        Route::get('deleteAjax/{id}',['as'=>'deleteAjax','uses'=>'App\Http\Controllers\Admin\SliderController@delete']);
    });


});
Route::group(['prefix' => 'customer', 'as' => 'customer.','middleware'=>['auth','client']], function () {
    Route::get('home', ['as'=>'home', 'uses'=>'App\Http\Controllers\Customer\HomeController@index']);

    Route::get('orders', ['as'=>'orders', 'uses'=>'App\Http\Controllers\Customer\HomeController@orders']);
    Route::get('getAjaxList',['as'=>'showAjaxList','uses'=>'App\Http\Controllers\Customer\HomeController@showList']);
    Route::get('order-show/{id}', ['as'=>'order_show', 'uses'=>'App\Http\Controllers\Customer\HomeController@order_show']);

    Route::get('my-profile', ['as'=>'my_profile', 'uses'=>'App\Http\Controllers\Customer\HomeController@myprofile']);
    Route::post('my-profile-save', ['as'=>'myprofile_save', 'uses'=>'App\Http\Controllers\Customer\HomeController@myprofile_save']);

    Route::get('wishlist', ['as'=>'wishlist', 'uses'=>'App\Http\Controllers\Customer\HomeController@wishlist']);
    Route::get('wishlist-remove/{id}', ['as'=>'wishlist_remove', 'uses'=>'App\Http\Controllers\Customer\HomeController@wishlist_remove']);
    Route::post('cancel_order/{id}', ['as'=>'cancel_order', 'uses'=>'App\Http\Controllers\Customer\HomeController@cancel_order']);
});
Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
    Route::post('load-locations',['as'=>'loadLocations','uses'=>'App\Http\Controllers\AjaxController@get_location']);

    Route::post('picture-delete',['as'=>'delete_file','uses'=>'App\Http\Controllers\CommonController@pictureDelete']);

    Route::post('ajax-upload',['as'=>'ajax_upload','uses'=>'App\Http\Controllers\CommonController@pictureUploadProperty']);
    Route::post('ajax-upload-single',['as'=>'ajax_upload','uses'=>'App\Http\Controllers\CommonController@pictureUploadSingle']);
    Route::post('ajax-delete',['as'=>'filedelete','uses'=>'App\Http\Controllers\CommonController@pictureDeleteProperty']);
    Route::post('information-ajax',['as'=>'information','middleware'=>['auth'],'uses'=>'App\Http\Controllers\OrdersController@information']);
    Route::post('email-check',['as'=>'email_check','uses'=>'App\Http\Controllers\AjaxController@email_check']);
    Route::post('order-traker-ajax',['as'=>'order_traker','middleware'=>['auth'],'uses'=>'App\Http\Controllers\OrdersController@order_track']);

});
Route::get('get-parent-category','App\Http\Controllers\Admin\CategoryController@get_category')->name('get_prent_category');

