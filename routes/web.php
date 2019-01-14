<?php
 

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['as' => 'admin.'], function() {
    // aqdmin dashboard
    Route::get('/admin', 'AdminController@dashboard')->name('dashboard');

    // product
    Route::resource('product', 'ProductController');


    // category
    Route::resource('category', 'CategoryController');

});