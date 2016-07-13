<?php

Route::group(['prefix' => config('keysql.route_prefix'),'middleware' => 'Zxc\Keysql\Http\Middleware\Authenticate'], function() {

    Route::group(['middleware' => 'Zxc\Keysql\Http\Middleware\ValidateKeysql'],function() {
        Route::get('/', 'HomeController@index');
        Route::get('{nav_id}', ['as' => 'getKeysql', 'uses' => 'HomeController@getKeysql'])->where('nav_id', '[0-9]+');
        Route::post('/', ['as' => 'postKeysql', 'uses' => 'HomeController@postKeysql']);
        Route::get('wx/{sql_id?}', 'HomeController@getwx');
        Route::get('searchnav', ['as'=>'searchnav','uses'=>'HomeController@searchnav']);
    });
    Route::group(['prefix'=>'admin','middleware' => 'Zxc\Keysql\Http\Middleware\ValidateAdmin'],function(){
        //admin
        Route::get('/',['as'=>'adminKeysql','uses'=>'AdminController@index']);
        Route::post('ajax',['as'=>'postAdminKeysqlAjax','uses'=>'AdminController@ajaxData']);
        //keysqlnav
        Route::post('postkeysqlnav',['as'=>'postKeysqlnav','uses'=>'AdminController@postKeysqlnav']);
        Route::get('keysqlnav',['as'=>'getAdminKeysqlnav','uses'=>'AdminController@getKeysqlnav']);
        //keysql
        Route::post('postkeysql',['as'=>'postAdminKeysql','uses'=>'AdminController@postKeysql']);
        Route::get('keysql',['as'=>'getAdminKeysql','uses'=>'AdminController@getKeysql']);
        //keysqltest
        Route::post('postkeysqltest',['as'=>'postAdminKeysqltest','uses'=>'AdminController@postKeysqltest']);
        Route::get('keysqltest',['as'=>'getAdminKeysqltest','uses'=>'AdminController@getKeysqltest']);
    });

});