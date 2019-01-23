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

// view extras options via ajax
Route::view('product/extras', 'admin.partial.extras')->name('product.extras');

// product resource
Route::resource('/product', 'ProductController');
});




// route for profile;
Route::group(['prefix' => 'admin', 'middleware'=>['auth','adminAuth'],'as'=>'admin.'], function() {
    Route::get('profile/{profile}/remove', 'ProfileController@remove')->name('profile.remove');
    Route::get('profile/trash', 'ProfileController@trash')->name('profile.trash');
    Route::get('profile/recover/{id}', 'ProfileController@recoverProduct')->name('profile.recover');
// calling extras options
    Route::view('profile/roles', 'admin.partials.extras')->name('profile.extras');

// calling from ajax
    Route::get('profile/states/{id?}', 'ProfileController@getStates')->name('profile.states');
    Route::get('profile/cities/{id?}', 'ProfileController@getCities')->name('profile.cities');
    
// resource route
    Route::resource('/profile', 'ProfileController');


});

