@extends('keysql::admin.home')

@section('css')
    <link rel="stylesheet" href="{{asset('statics/codemirror/lib/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('statics/codemirror/addon/display/fullscreen.css')}}">
    <link rel="stylesheet" href="{{asset('statics/codemirror/theme/cobalt.css')}}">
    <link rel="stylesheet" href="{{asset('statics/codemirror/theme/eclipse.css')}}">
    <link rel="stylesheet" href="{{asset('statics/codemirror/theme/midnight.css')}}">
    <link rel="stylesheet" href="{{asset('statics/codemirror/theme/monokai.css')}}">
    <link rel="stylesheet" href="{{asset('statics/codemirror/theme/rubyblue.css')}}">
    <link rel="stylesheet" href="{{asset('statics/codemirror/theme/vibrant-ink.css')}}">
    <style type="text/css">
        .CodeMirror {
            border: 1px solid black;
            font-size: 13px
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#sql_box" data-toggle="tab">SQL设置</a></li>
                <li role="presentation"><a href="#key_id_json_box" data-toggle="tab">表格设置</a></li>
                <li role="presentation"><a href="#echart_json_box" data-toggle="tab">图形设计</a></li>
                <li role="presentation"><a href="#wx_str_box" data-toggle="tab">引用设置</a></li>
            </ul>
        </div>
        <br/>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="sql_box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">一、SQL标记</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>小提示：</strong>
                                    <br/>1、<strong>数据源</strong>在config/databases.php文件里配置
                                    <br/>2、<strong>SQL描述</strong>就是SQL的名称，请务必填写
                                </div>
                                <div class="form-inline">
                                    <div class="input-group">
                                        <span class="input-group-addon">数据源</span>
                                        <select class="form-control" name="conn" id="conn">
                                            @foreach($dbs as $db_name=>$db_value)
                                                <option value="{{$db_name}}" @if($db_name==$data['conn']) selected @endif>{{$db_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">SQL描述</span>
                                        <input type="text" class="form-control" id="sql_desc" name="sql_desc" size="16" value="{{$data['sql_desc'] or ''}}" placeholder="用于识别SQL的唯一描述">
                                    </div>
                                </div>
                            </div>
                        </div><!--/.row-->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">二、SQL录入</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>小提示：</strong>
                                    <br/>1、在编辑器中，按<strong>F11</strong>可以切换全屏模式
                                    <br/>2、<strong>设计变量</strong>时，可使用符号$作为php变量，如$startdate
                                    <br/>3、<strong>php操作</strong>时，可使用符号".."包含php语句，如日期变换".date('Y-m-d'，strtotime(-1 day))."
                                    <br/>4、<strong>开启临时表</strong>时，必须包含日期型字段logtime，且必须用$startdate和$enddate筛选
                                </div>
                                <article>
                                    <textarea id="sqlstr" name="sqlstr" >
@if($data && $data['sqlstr'])
{{trim($data['sqlstr'])}}
@else
-- SQL Mode for CodeMirror
SELECT SQL_NO_CACHE DISTINCT
@var1 AS `val1`, @'val2', @global.'sql_mode',
1.1 AS `float_val`, .14 AS `another_float`, 0.09e3 AS `int_with_esp`,
0xFA5 AS `hex`, x'fa5' AS `hex2`, 0b101 AS `bin`, b'101' AS `bin2`,
DATE '1994-01-01' AS `sql_date`, { T "1994-01-01" } AS `odbc_date`,
'my string', _utf8'your string', N'her string',
TRUE, FALSE, UNKNOWN
FROM DUAL
-- space needed after '--'
# 1 line comment
/* multiline
comment! */
LIMIT 1 OFFSET 0;
@endif
                                    </textarea>
                                </article>
                            </div>
                        </div><!-- /.box -->
                        
                        
                        
                        <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">三、变量设置</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>小提示：</strong>
                            <br/>1.<strong>数据替换</strong>：使用$data数组数据，第一维度为从0开始的行号，第二维度为字段
                            <br/>2.举例说明：日报表里的$data[0]['pay']表示第一行的pay字段的值
                            <br/>3.访问链接：网址/keysql/wx/本SQL的ID
                        </div>
                        <article>
                            <textarea id="var_json" name="var_json">
{{preg_replace('/((?<=}|{)\s*)/i',chr(13).chr(10),trim($data['var_json']))}}
                            </textarea>
                        </article>
                    </div>
                </div>
                        
                    </div><!--/.col-->
                </div><!--/.row-->
            </div><!--/.tab-pane-->
            
            <div role="tabpanel" class="tab-pane" id="key_id_json_box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">字段设置</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>小提示：</strong>
                                    <br/>1、<strong>字段设置</strong>就是key_id_json，是json格式
                                    <br/>2、<strong>name</strong>：字段对应的表格标题
                                    <br/>3、<strong>type</strong>：创建临时表时，字段对应的类型
                                    <br/>4、<strong>desc</strong>：描述该字段指标
                                </div>
                                <div class="col-sm-6">
                                    <span>参考设置:</span>
                                    <div class="alert alert-info">
                                        <div id="key_id_json_re">
                                        </div>
                                    </div>
                                </div>
                                <article class="col-sm-6">
                                    实际设置:  (点击编辑框以激活控件)
                                    <textarea id="key_id_json" name="key_id_json">
{{$data['key_id_json'] or ''}}
                                    </textarea>
                                </article>
                            </div>
                        </div><!--box-->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">本地表设置</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>请注意!</strong>
                                    <br/>1.本地表必须有<strong>logtime</strong>字段，且由其作为日期选择条件；
                                    <br/>2.暂时不支持其他选择条件；
                                    <br/>3.命名本地表后，即建立本地表，否则不建立；
                                    <br/>4.周期字段在命名本地表后有效，1日，2周，4月，更替内置的时间变量；
                                </div>
                                <div class="col-sm-3 " >
                                    <div class="input-group">
                                        <span class="input-group-addon">本地表名</span>
                                        <input type="text" class="form-control" id="intotable" name="intotable" size="16" value="{{$data['intotable'] or ''}}" placeholder="存储在本地的数据表">
                                    </div>
                                </div>
                                <div class="col-sm-3 " >
                                    <div class="input-group">
                                        <span class="input-group-addon">周期</span>
                                        <input type="text" class="form-control" id="cron" name="cron" size="16" value="{{$data['cron'] or '0'}}" >
                                    </div>
                                </div>
                                <div class="col-sm-3 " >
                                    <button class="btn btn-warning btn-block" id="truncate">清空本地表</button>
                                </div>
                                <div class="col-sm-3 " >
                                    <button class="btn btn-danger btn-block" id="delete">删除本地表</button>
                                </div>
                            </div>
                        </div><!--/.box-->
                
                    </div><!--/.col-->
                </div><!--/.row-->
            </div><!--/.tab-pane-->
            
            <div role="tabpanel" class="tab-pane" id="echart_json_box">
 
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">图形设置</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <article>
                            <textarea id="echart_json" name="echart_json">
{{$data['echart_json'] or ''}}
                            </textarea>
                        </article>
                    </div>
                </div>
            </div>
            
            <div role="tabpanel" class="tab-pane" id="wx_str_box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title">微信字符串设置</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>小提示：</strong>
                                    <br/>1.<strong>数据替换</strong>：使用$data数组数据，第一维度为从0开始的行号，第二维度为字段
                                    <br/>2.举例说明：日报表里的$data[0]['pay']表示第一行的pay字段的值
                                    <br/>3.访问链接：网址/keysql/wx/本SQL的ID
                                </div>
                                <article>
                                    <textarea id="wx_str" name="wx_str">
{{$data['wx_str'] or ''}}
                                    </textarea>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div><!--/.tab-content-->
        <br/>
        <div class="row">
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">主题选择</span>
                    <select class="form-control" id="select">
                        <option selected>default</option>
                        <option>eclipse</option>
                        <option>midnight</option>
                        <option>monokai</option>
                        <option>vibrant-ink</option>
                        <option>cobalt</option>
                        <option>rubyblue</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4" >
                <button class="btn btn-primary btn-block" id="save">保存信息</button>
            </div>
            <div class="col-sm-4" >
                <a class="btn btn-success btn-block" id="save-preview" href="{{asset(route('getAdminKeysqltest',['id'=>$sql_id]))}}" target="_blank">效果预览</a>
            </div>
        </div><!--/.row-->
    </div>
@endsection

@section('script')
    <script src="{{asset('statics/codemirror/lib/codemirror.js')}}"></script>
    <script src="{{asset('statics/codemirror/mode/sql/sql.js')}}"></script>
    <script src="{{asset('statics/codemirror/addon/selection/active-line.js')}}"></script>
    <script src="{{asset('statics/codemirror/addon/edit/matchbrackets.js')}}"></script>
    <script src="{{asset('statics/codemirror/addon/display/fullscreen.js')}}"></script>
    <script type="text/javascript" language="javascript">
        function get_data(){
            return {
                sql_id:'{{$sql_id}}',
                sqlstr:editor.getValue(),
                key_id_json:key_id_json_editor.getValue(),
                var_json:var_json_editor.getValue(),
                echart_json:echart_json_editor.getValue(),
                wx_str:wx_str_editor.getValue(),
                intotable:$('#intotable').val(),
                cron:$('#cron').val(),
                conn:$('#conn').val(),
                sql_desc:$('#sql_desc').val()
            };
        }
        function save_ajax(){
            $("#loader").fadeIn();
            $(".mask").fadeIn();
            var path='{{route('getAdminKeysql')}}';
            var sql_id={{$sql_id}};
            $.ajax({
                url:'{{route('postAdminKeysql')}}',
                data: get_data(),
                type: 'POST',
                async:true,
                error: function(request) {
                    $("#loader").fadeOut(300);
                    $(".mask").fadeOut(300);
                    alert("Connection error");
                },
                success:function(data){
                    if(data!=sql_id){
                        window.location.href=path+"?id="+data;
                    }
                    $("#loader").fadeOut(300);
                    $(".mask").fadeOut(300);
                }
            });
        }
        function del_ajax(type){
            $("#loader").fadeIn();
            $(".mask").fadeIn();
            $.ajax({
                url:'{{route('postAdminKeysqltest')}}',
                data: {type:type,sql_id:'{{$sql_id}}'},
                type: 'POST',
                async:true,
                error: function(request) {
                    $("#loader").fadeOut(300);
                    $(".mask").fadeOut(300);
                    alert("Connection error");
                },
                success:function(data){
                    $("#loader").fadeOut(300);
                    $(".mask").fadeOut(300);
                }
            });
        }
    </script>
    <script type="text/javascript" language="javascript">
        function codeMirror(id) {
            var editor = CodeMirror.fromTextArea(document.getElementById(id), {
                mode: 'text/x-sql',
                styleActiveLine: true,
                indentWithTabs: true,
                smartIndent: true,
                lineNumbers: true,
                matchBrackets: true,
                autofocus: true,
                extraKeys: {
                    "Ctrl-Space": "autocomplete",
                    "F11": function (cm) {
                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                        $('header').toggle();
                        $('aside').toggle();
                    }
                }
            });
            return editor;
        }
        function key_id_json_re(){
            var sqlstr=editor.getValue();
            sqlstr=sqlstr.replace(/^[\S\s]*;(?=\s*\w+)/ig, "");
            if(sqlstr.match(/\s+into\s+/ig)){
                $('#key_id_json_re').text('');
            }else{
                sqlstr=sqlstr.replace(/([\S\s]*^select)|([\S\s]*[^\(|\s]+select\s+)|(\s+from[\s|\(]+[\S\s]*)/img, "");
                var var_arr=sqlstr.split(',');
                var var_str='<br/>{<br/>';
                var len=var_arr.length;
                for( var i in var_arr){
                    //var_arr[i]=var_arr[i].replace(/(\w*\.)|([\S\s]*\s+(?=[`\[\w]+))/ig,"");
                    //var_arr[i]=var_arr[i].match(/\w+/ig);
                    var_arr[i]=var_arr[i].replace(/(\w*\.)|([\S\s]*\s+(?=[`\[\w\u4e00-\u9fa5]+))/ig,"");
                    var_arr[i]=var_arr[i].match(/([\w\u4e00-\u9fa5])+/ig);
                    var_str+='"'+var_arr[i]+'":{"name":"'+var_arr[i]+'","type":""}';
                    if(i<len-1){
                        var_str+=',<br/>';
                    }
                }
                var_str+='<br/>}<br/>';
                $('#key_id_json_re').html(var_str);
            }
        }
        var editor = codeMirror('sqlstr');
        var key_id_json_editor = codeMirror('key_id_json');
        var var_json_editor = codeMirror('var_json');
        var echart_json_editor = codeMirror('echart_json');
        var wx_str_editor = codeMirror('wx_str');
    </script>
    <script type="text/javascript" language="javascript">
        $(function(){
            
            
            $('#select').change(function(){
                var theme = $(this).find("option:selected").text();
                editor.setOption("theme", theme);
                key_id_json_editor.setOption("theme", theme);
                var_json_editor.setOption("theme", theme);
                echart_json_editor.setOption("theme", theme);
                wx_str_editor.setOption("theme", theme);
            });
            
            $('#json-set button').click(function(){
                $(this).toggleClass('active');
            });
            //editor事件监控
            editor.on("change",function(){
                key_id_json_re();
            });
            $('#save').click(function(){
                save_ajax();
            });
            $('#delete').click(function(){
                if(confirm('Are you sure?')){
                    del_ajax('delete');
                }
            });
            $('#truncate').click(function(){
                if(confirm('Are you sure?')) {
                    del_ajax('truncate');
                }
            });
        });
    </script>
@endsection
