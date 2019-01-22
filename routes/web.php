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
// category pysically deleted
Route::get('/category/{category}/remove', 'CategoryController@remove')->name('category.remove');
// category trash
Route::get('/category/trash', 'CategoryController@trash')->name('category.trash');
// trashed item permaneetly deletinng
// Route::get('/category/{id}', 'CategoryController@trashedItemDeletePermanetly')->name('category.removeTrashed');
// category recover
Route::get('/category/recover/{id}', 'CategoryController@recover')->name('category.recover');
// aqdmin dashboard
Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');

// category
Route::resource('/category', 'CategoryController');
});








/* route forr products

*/
Route::group(['as'=>'admin.','prefix' => 'admin','middleware'=>['auth','adminAuth']], function() {
// product pysically deleted
Route::get('/product/{product}/remove', 'ProductController@remove')->name('product.remove');
// product trash
Route::get('/product/trash', 'ProductController@trash')->name('product.trash');

// product recover
Route::get('/product/recover/{id}', 'ProductController@recover')->name('product.recover');
// trashed item permaneetly deletinng
Route::get('/product/trash/{id}', 'ProductController@trashedItemDeletePermanetly')->name('product.removeTrashed');

// product resource
Route::resource('/product', 'ProductController');



});