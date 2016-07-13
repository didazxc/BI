<?php

Route::group([
    'prefix' => config('keytask.route_prefix'),
    'middleware' => 'Zxc\Keytask\Http\Middleware\Authenticate',
], function() {
    Route::get('/', ['uses'=>'KeytaskController@index']);
    Route::get('dlist', ['as'=>'demandlist','uses'=>'KeytaskController@getDemandList']);
    Route::get('tinfo', ['as'=>'taskinfo','uses'=>'KeytaskController@getTaskInfo']);
    
    Route::group(['middleware' => 'Zxc\Keytask\Http\Middleware\DemandIdentify'],function() {
        Route::get('dedit', ['as'=>'demandedit','uses'=>'KeytaskController@getDemandEdit']);
        Route::post('dedit', ['as'=>'postdemandedit','uses'=>'KeytaskController@postDemandEdit']);
        Route::post('ddlete', ['as'=>'postdemanddelete','uses'=>'KeytaskController@postDemandDelete']);
        Route::post('dcancel', ['as'=>'postdemandcancel','uses'=>'KeytaskController@postDemandCancel']);
    });
    
    Route::group(['middleware' => 'Zxc\Keytask\Http\Middleware\TaskIdentify'],function() {
        Route::get('tlist', ['as'=>'tasklist','uses'=>'KeytaskController@getTaskList']);
        Route::get('tedit', ['as'=>'taskedit','uses'=>'KeytaskController@getTaskEdit']);
        Route::post('tedit', ['as'=>'posttaskedit','uses'=>'KeytaskController@postTaskEdit']);
        Route::post('treceive', ['as'=>'posttaskreceive','uses'=>'KeytaskController@postTaskReceive']);
        Route::post('tcancel', ['as'=>'posttaskcancel','uses'=>'KeytaskController@postTaskCancel']);
        Route::post('tdone', ['as'=>'posttaskdone','uses'=>'KeytaskController@postTaskDone']);
        Route::post('thour', ['as'=>'posttaskhour','uses'=>'KeytaskController@postTaskHour']);
        Route::post('thourd', ['as'=>'taskhourdelete','uses'=>'KeytaskController@postTaskHourDelete']); 
    });
    
    
});