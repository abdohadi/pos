<?php


Route::group([
	'prefix' => LaravelLocalization::setLocale(),
	// 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewfPath' ]
], function(){ 

	// any route in this group 'dashboard/route'
	// any name in this group 'dashboard.name'
	Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function() {	
		// dashboard/index
	 	Route::get('/index', 'DashboardController@index')->name('index');

		// category routes
		Route::resource('categories', 'CategoriesController');

		// product routes
		Route::resource('products', 'ProductsController');

		// client routes
		Route::resource('clients', 'ClientsController');
		Route::resource('clients.orders', 'Clients\OrdersController');

		// order routes
		Route::resource('orders', 'OrdersController');
		Route::get('orders/{order}/products', 'OrdersController@products')->name('orders.products');

		// user routes
		Route::resource('users', 'UsersController');
	});

});



