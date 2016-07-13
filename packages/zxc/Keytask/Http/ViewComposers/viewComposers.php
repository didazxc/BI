<?php

view()->composer('keytask::_layouts.nav',function($view){
    $view->nav_array=config('keytask.nav_array');
});

view()->composer('keytask::_layouts.sidebar',function($view){
    $sidebar_array=config('keytask.sidebar_array');
    $view->sidebar_array=$sidebar_array;
});

view()->composer('keytask::_layouts.default',function($view){
    //加载css插件
    $view->css = array(
        'bootstrap' => asset('/statics/bootstrap/css/bootstrap.min.css'),
        'fontAwesome' => asset('/statics/Font-Awesome/css/font-awesome.min.css'),
        'dataTables' => asset('/statics/DataTables/media/css/dataTables.bootstrap.min.css'),
        'dataTables-buttons' => asset('/statics/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css'),
        'dataTables-Select' => asset('/statics/DataTables/extensions/Select/css/select.bootstrap.min.css'),
        'datetimepicker' => asset('/statics/datetimepicker/css/bootstrap-datetimepicker.min.css'),
        'css' => asset('packages/zxc/css/keytask.css'),
    );
    $view->headjs_ie8 = array(
        'jquery'=>asset('/statics/jquery/1.11.2/jquery.min.js'),
        'bootstrap'=>asset('/statics/bootstrap/js/html5shiv.js'),
    );
    $view->headjs = array(
        'jquery'=>asset('/statics/jquery/jquery-2.2.4.min.js'),
        'bootstrap'=>asset('/statics/bootstrap/js/bootstrap.min.js'),
    );
    //加载js插件
    $view->js = array(
        'datetimepicker' => asset('/statics/datetimepicker/js/bootstrap-datetimepicker.min.js'),
        'datetimepicker-zh' => asset('/statics/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js'),
        'datetimepicker-js' => asset('/packages/zxc/js/datetimepicker.js'),
        
        'dataTables' => asset('/statics/DataTables/media/js/jquery.dataTables.min.js'),
        'dataTables-set' => asset('/packages/zxc/js/datatables.js'),
        'dataTables-bootstrap' => asset('/statics/DataTables/media/js/dataTables.bootstrap.min.js'),
        'dataTables-buttons' => asset('/statics/DataTables/extensions/Buttons/js/dataTables.buttons.min.js'),
        'dataTables-buttons-bootstrap' => asset('/statics/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js'),
        'dataTables-buttons-html5' => asset('/statics/DataTables/extensions/Buttons/js/buttons.html5.min.js'),
        'dataTables-jszip' => asset('/packages/zxc/js/jszip.min.js'),
        'dataTables-Select' => asset('/statics/DataTables/extensions/Select/js/dataTables.select.min.js'),
        
        'ueditor_config'=>asset('/statics/ueditor/utf8-php/ueditor.config.js'),
		'ueditor'=>asset('/statics/ueditor/utf8-php/ueditor.all.min.js'),
        'ueditor_parse'=>asset('/statics/ueditor/utf8-php/ueditor.parse.min.js'),

        'js' => asset('packages/zxc/js/app.js'),
    );

});