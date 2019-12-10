<?php



// any route in this group 'dashboard/route'
// any name in this group 'dashboard.name'
Route::prefix('dashboard')->name('dashboard.')->group(function() {	

	Route::get('/index', 'DashboardController@index')->name('index');

});

