<?php

Route::group(['middleware' => ['web']], function () {

    Route::resource('fellas','ProductController');
    Route::get('/', function () {
        return view('welcome');
    });

    Route::auth();

    Route::get('/home', 'HomeController@index');

    Route::get('products',['as'=>'products.index','uses'=>'ProductController@index']);
    Route::get('products/{products}',['as'=>'product.order','uses'=>'ProductController@order']);

    Route::post('paypal',['as'=>'pay','uses'=>'PaypalController@payment']);

    Route::get('payment/status', ['as' => 'payment.status', 'uses' => 'PaypalController@getPaymentStatus']);
    
});
