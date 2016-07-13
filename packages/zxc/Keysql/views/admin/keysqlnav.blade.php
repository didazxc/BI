@extends('keysql::admin.home')

@section('content')
    <div class="container-fluid">
        <div class="row">
        <div class="row">
            <div class="col-xs-6 form-inline">
                <div class="input-group">
                    <span class="input-group-addon">模块</span>
                    <select class="form-control" name="id" id="root_id">
                        @foreach($select_list as $k=>$v)
                        <option value="{{$k}}" @if($root_id==$k) selected @endif>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6">
                <button id="newNavBtn" class="btn btn-primary pull-right" data-toggle="modal" data-target="#newNavModal">新建导航</button>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <style>
                    table {
                        width: 100%;
                    }
                    i.fa {
                        width: 20px;
                    }
                    a,a:link,a:visited,a:hover,a:active{
                        text-decoration: none;
                    }
                </style>
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap" id="keysqlnav-table"  cellspacing="0">
                    <thead>
                    <tr>
                        <th style="min-width:210px;">导航名称</th>
                        <th>权限名</th>
                        <th>SQL_ID</th>
                        <th>SQL描述或链接</th>
                        <th style="min-width:120px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                        $traverse = function ($categories) use (&$traverse,$root_depth) {
                            foreach ($categories as $node) {
                    ?>
                    <tr data-lft="{{$node['_lft']}}" data-rgt="{{$node['_rgt']}}">
                        <td>
                            @if($node['depth']>$root_depth)
                            {!! str_repeat('<i class="fa">┊</i>',$node['depth']-$root_depth-1) !!}
                            <i class="fa">{{(isset($node['last'])?'┗':'┣')}}</i>
                            @endif
                            @if(count($node['children']))
                                <a class="nav-collapse" data-id="{{$node['id']}}" href="#">
                                    <i class="fa fa-minus-square-o"></i>
                                </a>
                            @else
                                <i class="fa fa-square-o"></i>
                            @endif
                            <i class="fa {{$node['fa_icon']}}"></i>
                            {{$node['name']}}
                        </td>
                        <td>{{config('keysql.permission_prefix').$node['id']}}</td>
                        @if($node['sql_id'])
                            <td><a href="{{route('getAdminKeysql',['id'=>$node['sql_id']])}}">{{$node['sql_id']}}</a></td>
                            <td>{{$node['keysql']['sql_desc'] or ''}}</td>
                        @else
                            <td>链接</td>
                            <td>{{$node['href'] or ''}}</td>
                        @endif
                        <td>
                            <button class="btn btn-success btn-xs nav-edit" data-id="{{$node['id']}}" onclick="navedit({{$node['id']}})"><i class="fa fa-pencil"></i>编辑</button>
                            <button class="btn btn-danger btn-xs nav-delete" data-id="{{$node['id']}}" onclick="navdelete({{$node['id']}})"><i class="fa fa-remove"></i>删除</button>
                        </td>
                    </tr>
                    <?php
                                $traverse($node->children);
                            }
                        };

                        $traverse($keysql_nav_tree);
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
        </div>
    </div>
    <div id="newNavModal" class="modal fade" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content box">
                <div class="overlay" id="newNavModalOverlay">
                  <i class="fa fa-spinner fa-spin"></i>
                </div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">编辑导航</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="navform">
                        <input id="inputId" name="id" value="" hidden readonly />
                        <div class="form-group">
                            <label for="inputPid" class="col-sm-2 control-label">父节点</label>
                            <div class="col-sm-10">
                                <select  class="form-control" id="inputPid" name="pid">
                                    <option value="1">Root根节点</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">导航名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="导航名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDesc" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputDesc" name="desc" placeholder="基本的功能描述">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputFaIcon" class="col-sm-2 control-label">图标</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputFaIcon" name="fa_icon" placeholder="font-awesome图标">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputHref" class="col-sm-2 control-label">链接</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputHref" name="href" placeholder="挂载SQL时可以不填">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSQL" class="col-sm-2 control-label">SQL</label>
                            <div class="col-sm-10">
                                <select  class="form-control" id="inputSQL" name="sql_id">
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="saveNav">保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('statics/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('statics/multiselect/dist/css/bootstrap-multiselect.css')}}">
@endsection

@section('script')
    <script src="{{asset('statics/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('statics/DataTables/extensions/Responsive/js/responsive.bootstrap.min.js')}}"></script>
    <script src="{{asset('statics/multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
    
    <script type="text/javascript">

        function saveNav(){
            $.ajax({
                url: '{{route('postKeysqlnav')}}',
                data: $('#navform').serialize(),
                type: 'POST',
                async: true,
                error: function(request) {
                    $("#loader").fadeOut(300);
                    $(".mask").fadeOut(300);
                    alert("Connection error");
                },
                success: function(d){
                    location.reload();
                }
            });
        }

        function deleteNav(navid){
            $.ajax({
                url: '{{route('postKeysqlnav')}}',
                data: {navid:navid,type:"delete"},
                type: 'POST',
                async: true,
                error: function(request) {
                    $("#loader").fadeOut(300);
                    $(".mask").fadeOut(300);
                    alert("Connection error");
                },
                success: function(d){
                    location.reload();
                }
            });
        }

        function getlist(navid){
            $('#newNavModalOverlay').show();
            $.ajax({
                url:'{{route('postAdminKeysqlAjax')}}',
                data:{navid:navid,lev1_node_id:'1'},
                type:'POST',
                async: true,
                error: function(request) {
                    alert("Connection error1");
                    $('#newNavModalOverlay').fadeOut(300);
                },
                success: function(d){
                    $('#inputPid').empty();
                    for(var navid in d['navlist']){
                        var str='<option value="'+d['navlist'][navid]['id']+'" ';
                        if(d['thisnav']['parent_id']==d['navlist'][navid]['id']){
                            str+='selected';
                        }
                        var prifix_str='^';
                        for(var i=0;i<d['navlist'][navid]['depth'];i++){
                            prifix_str+='_';
                        }
                        prifix_str+='^';
                        str+='>'+prifix_str+d['navlist'][navid]['name']+'</option>';
                        $('#inputPid').append(str);
                    };
                    $('#inputId').val(d['thisnav']['id']);
                    $('#inputName').val(d['thisnav']['name']);
                    $('#inputDesc').val(d['thisnav']['desc']);
                    $('#inputHref').val(d['thisnav']['href']);
                    $('#inputFaIcon').val(d['thisnav']['fa_icon']);
                    $('#inputSQL').empty();
                    $('#inputSQL').append('<option value="0"></option>');
                    for(var sqlid in d['sqllist']){
                        var str='<option value="'+sqlid+'" ';
                        if(d['thisnav']['sql_id']==sqlid){
                            str+='selected';
                        }
                        str+='>'+d['sqllist'][sqlid]+'</option>';
                        $('#inputSQL').append(str);
                    };
                    $('#inputPid').multiselect('rebuild');
                    $('#inputSQL').multiselect('rebuild');
                    $('#newNavModalOverlay').fadeOut(300);
                }
            });
        }

        function navedit(id){
            $('#newNavModal .modal-header .modal-title').text('编辑导航');
            $('#newNavModal').modal('show');
            getlist(id);
        }
        
        function navdelete(id){
            if(confirm('确定删除？会删除其下所有子节点.')){
                deleteNav(id);
            }
        }
        
        
        $(function () {
            var table = $('#keysqlnav-table').DataTable({
                lengthChange:false,
                ordering:false,
                searching:false,
                info:false,
                paging:false,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ]
            });
            $('#root_id').change(function(){
                location.href="?id="+$(this).val();
            });
            $('#keysqlnav-table a.nav-collapse').click(function () {
                var lft = $(this).parents('tr').data('lft');
                var rgt = $(this).parents('tr').data('rgt');
                
				if($(this).children('i.fa').hasClass('fa-minus-square-o')){
					$(this).children('i.fa').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
					$('#keysqlnav-table tr').each(function(){
                        if($(this).data('lft')>lft && $(this).data('rgt')<rgt){
                            $(this).hide(300);
                        }
                    });
				}else{
					$(this).children('i.fa').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
					var next_lft=lft+1;
                    $('#keysqlnav-table tr').each(function(){
						if($(this).data('lft')>lft && $(this).data('rgt')<rgt){
                            //$(this).find('i.fa-plus-square-o').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                            if($(this).data('lft')==next_lft){
                                $(this).find('i.fa-minus-square-o').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                                $(this).show(300);
                                next_lft=$(this).data('rgt')+1;
                            }
                        }
					});
				}
                return false;
            });
            $('#newNavBtn').click(function(){
                $('#newNavModal .modal-header .modal-title').text('新建导航');
                getlist(0);
            });
            $('#saveNav').click(function(){
                $("#loader").fadeIn();
                $(".mask").fadeIn();
                saveNav();
            });
            $('#inputPid').multiselect({
                enableFiltering: true
            });
            $('#inputSQL').multiselect({
                enableFiltering: true
            });
        });
    </script>
@endsection
