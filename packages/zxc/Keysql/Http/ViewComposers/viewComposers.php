<?php
//blade继承时，子blade的变量会传递给母blade，include时不会
//keysql母版
view()->composer('keysql::layouts.default',function($view)
{
    $view->headjs_ie8 = array(
        'jquery'=>asset('/statics/jquery/1.11.2/jquery.min.js'),
        'html5shiv'=>asset('/statics/bootstrap/js/html5shiv.js'),
    );
    $view->headjs = array(
        'jquery'=>asset('/statics/jquery/jquery-2.2.4.min.js'),
        'bootstrap'=>asset('/statics/bootstrap/js/bootstrap.min.js'),
    );
    //加载css插件
    $view->css = array_merge(array(
        'bootstrap' => asset('/statics/bootstrap/css/bootstrap.min.css'),
        'fontAwesome' => asset('/statics/Font-Awesome/css/font-awesome.min.css'),
        'ionicons' => asset('/statics/ionicons/css/ionicons.min.css'),
        'adminLTE' => asset('/statics/AdminLTE2/dist/css/AdminLTE.min.css'),
        'appcss' => asset('/packages/zxc/css/app.css'),
    ),$view->css?$view->css:[]);
    //加载js插件
    $view->js = array_merge(array(
        'adminLTE'=>asset('/statics/AdminLTE2/dist/js/app.min.js'),
        'appjs'=>asset('/packages/zxc/js/app.js'),
    ),$view->js?$view->js:[]);
});
//keysql前端
view()->composer('keysql::home.home',function($view)
{
    $view->css = array_merge(array(
        'adminLTE_skin' => asset('statics/AdminLTE2/dist/css/skins/skin-blue.min.css'),
        'datatables' => asset('statics/DataTables/media/css/dataTables.bootstrap.min.css'),
        'datatables_buttons' => asset('statics/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css'),
        'datatables_fixcolumns' => asset('statics/DataTables/extensions/FixedColumns/css/fixedColumns.bootstrap.min.css'),
        'daterangepicker' =>asset('statics/daterangepicker/daterangepicker.css'),
    ),$view->css?$view->css:[]);
    $view->js = array_merge(array(
        'datatables_jquery'=>asset('statics/DataTables/media/js/jquery.dataTables.min.js'),
        'datatables_bootstrap'=>asset('statics/DataTables/media/js/dataTables.bootstrap.min.js'),
        'datatables_buttons'=>asset('statics/DataTables/extensions/Buttons/js/dataTables.buttons.min.js'),
        'datatables_buttons_bootstrap'=>asset('statics/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js'),
        'datatables_jszip'=>asset('packages/zxc/js/jszip.min.js'),
        'datatables_buttons_html5'=>asset('statics/DataTables/extensions/Buttons/js/buttons.html5.min.js'),
        'datatables_buttons_colvis'=>asset('statics/DataTables/extensions/Buttons/js/buttons.colVis.min.js'),
        'datatables_fixedcolumns'=>asset('statics/DataTables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js'),
        'datatables_appjs'=>asset('packages/zxc/js/datatables.js'),
        'moment'=>asset('statics/daterangepicker/moment.min.js'),
        'moment_zh_cn'=>asset('statics/daterangepicker/moment-zh-cn.min.js'),
        'daterangepicker'=>asset('statics/daterangepicker/daterangepicker.js'),
        
        'sparkline' => asset('statics/sparkline/jquery.sparkline.min.js'),
        'echarts' => asset('statics/echarts/echarts.min.js'),
        'appevents' => asset('packages/zxc/js/events.js'),
    ),$view->js?$view->js:[]);
});
//keysql后端
view()->composer('keysql::admin.home',function($view)
{
    $view->css = array_merge(array(
        'adminLTE_skin' => asset('statics/AdminLTE2/dist/css/skins/_all-skins.min.css'),
        'datatables' => asset('statics/DataTables/media/css/dataTables.bootstrap.min.css'),
        'datatables_buttons' => asset('statics/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css'),
        'datatables_fixcolumns' => asset('statics/DataTables/extensions/FixedColumns/css/fixedColumns.bootstrap.min.css'),
        'daterangepicker' =>asset('statics/daterangepicker/daterangepicker.css'),
        'datatables_responsive'=>asset('statics/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css'),
        'datatables_select'=>asset('statics/DataTables/extensions/Select/css/select.bootstrap.min.css'),
        'multiselect'=>asset('statics/multiselect/css/bootstrap-multiselect.css'),
        'codemirror'=>asset('statics/codemirror/lib/codemirror.css'),
        'codemirror_fullscreen'=>asset('statics/codemirror/addon/display/fullscreen.css'),
        'codemirror_theme_cobalt'=>asset('statics/codemirror/theme/cobalt.css'),
        'codemirror_theme_eclipse'=>asset('statics/codemirror/theme/eclipse.css'),
        'codemirror_theme_midnight'=>asset('statics/codemirror/theme/midnight.css'),
        'codemirror_theme_monokai'=>asset('statics/codemirror/theme/monokai.css'),
        'codemirror_theme_rubyblue'=>asset('statics/codemirror/theme/rubyblue.css'),
        'codemirror_theme_vibrantInk'=>asset('statics/codemirror/theme/vibrant-ink.css'),
    ),$view->css?$view->css:[]);
    $view->js = array_merge(array(
        //'adminLTE_demo' => asset('statics/AdminLTE2/dist/js/demo.js'),
        'datatables_jquery'=>asset('statics/DataTables/media/js/jquery.dataTables.min.js'),
        'datatables_bootstrap'=>asset('statics/DataTables/media/js/dataTables.bootstrap.min.js'),
        'datatables_buttons'=>asset('statics/DataTables/extensions/Buttons/js/dataTables.buttons.min.js'),
        'datatables_buttons_bootstrap'=>asset('statics/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js'),
        'datatables_jszip'=>asset('packages/zxc/js/jszip.min.js'),
        'datatables_buttons_html5'=>asset('statics/DataTables/extensions/Buttons/js/buttons.html5.min.js'),
        'datatables_buttons_colvis'=>asset('statics/DataTables/extensions/Buttons/js/buttons.colVis.min.js'),
        'datatables_fixedcolumns'=>asset('statics/DataTables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js'),
        'datatables_appjs'=>asset('packages/zxc/js/datatables.js'),
        'moment'=>asset('statics/daterangepicker/moment.min.js'),
        'moment_zh_cn'=>asset('statics/daterangepicker/moment-zh-cn.min.js'),
        'daterangepicker'=>asset('statics/daterangepicker/daterangepicker.js'),
        
        'sparkline' => asset('statics/sparkline/jquery.sparkline.min.js'),
        'echarts' => asset('statics/echarts/echarts.min.js'),
        'appevents' => asset('packages/zxc/js/events.js'),
        'datatables_responsive'=>asset('statics/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'),
        'datatables_responsive_bootstrap'=>asset('statics/DataTables/extensions/Responsive/js/responsive.bootstrap.min.js'),
        'multiselect'=>asset('statics/multiselect/js/bootstrap-multiselect.js'),
        'datatables_select'=>asset('statics/DataTables/extensions/Select/js/dataTables.select.min.js'),
        'codemirror'=>asset('statics/codemirror/lib/codemirror.js'),
        'codemirror_sql'=>asset('statics/codemirror/mode/sql/sql.js'),
        'codemirror_activeLine'=>asset('statics/codemirror/addon/selection/active-line.js'),
        'codemirror_matchbrackets'=>asset('statics/codemirror/addon/edit/matchbrackets.js'),
        'codemirror_fullscreen'=>asset('statics/codemirror/addon/display/fullscreen.js'),
    ),$view->js?$view->js:[]);
});