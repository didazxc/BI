<?php

Route::group([
    'prefix' => config('keyact.route_prefix'),
	'middleware' => 'Zxc\Keyact\Http\Middleware\Authenticate',
], function() {
    Route::get('/', ['as'=>'home','uses'=>'KeyactController@index']);
	
	Route::group([
		'middleware' => 'Zxc\Keyact\Http\Middleware\Useridentify'
	],function(){
		Route::get('edit', ['as'=>'getEdit','uses'=>'KeyactController@getEdit']);
		Route::post('edit', ['as'=>'postEdit','uses'=>'KeyactController@postEdit']);
		Route::post('del',['as'=>'postDel','uses'=>'KeyactController@postDel']);
	});
	
	Route::get('info', ['as'=>'getInfo','uses'=>'KeyactController@getInfo']);
	Route::get('list', ['as'=>'getList','uses'=>'KeyactController@getList']);
	
});