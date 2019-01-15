<?php

Route::get('/', function () {
return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
/*
*url
* http://127.0.0.1:8000/admin/dashboard
*/
Route::group(['as' => 'admin.', 'prefix'=>'admin' , 'middleware'=>['auth', 'adminAuth']  ], function() {
// aqdmin dashboard
Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
// product
Route::resource('/product', 'ProductController');
// category
Route::resource('/category', 'CategoryController');
});