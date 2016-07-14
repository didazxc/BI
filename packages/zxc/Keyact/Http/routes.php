<?php

Route::group([
    'prefix' => config('keyact.route_prefix'),
	'middleware' => 'Zxc\Keyact\Http\Middleware\Authenticate',
], function() {
    Route::get('/', ['as'=>'acthome','uses'=>'KeyactController@index']);
	
	Route::group([
		'middleware' => 'Zxc\Keyact\Http\Middleware\Useridentify'
	],function(){
		Route::get('edit', ['as'=>'actEdit','uses'=>'KeyactController@getEdit']);
		Route::post('edit', ['as'=>'postActEdit','uses'=>'KeyactController@postEdit']);
		Route::post('del',['as'=>'postActDel','uses'=>'KeyactController@postDel']);
	});
	
	Route::get('info', ['as'=>'actInfo','uses'=>'KeyactController@getInfo']);
	Route::get('list', ['as'=>'actList','uses'=>'KeyactController@getList']);
	
});