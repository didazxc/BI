<?php

Route::group(['prefix' => config('keyalert.route_prefix')], function() {
    Route::get('wx', 'HomeController@getwx');
    Route::get('alertlist', ['as'=>'alertlist','uses'=>'HomeController@getAlertlist']);
});