@extends('keytask::_layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <form class="report-form col-sm-10 form-inline" id="report-form" method="get" >
				<div class="form-group">
					<div class="input-group date form_date"  data-date="{{$startdate}}" data-date-format="yyyy-mm-dd" >
						<span class="input-group-addon">起</span>
						<input class="form-control" name="startdate" size="15" type="text" value="{{$startdate}}" autocomplete="off" readonly />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
                </div>
                <div class="form-group">
					<div class="input-group date form_date"  data-date="{{$enddate}}" data-date-format="yyyy-mm-dd" >
						<span class="input-group-addon">止</span>
						<input class="form-control" name="enddate" size="15" type="text" value="{{$enddate}}" autocomplete="off" readonly />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
				<input type="submit" id="submit" class="btn btn-primary" value="提交查询">
			</form>
        </div>
        <hr/>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover table-striped table-bordered table-condensed text-center" id="tasklist" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width:20%">名称</th>
                            <th style="width:10%">创建人</th>
                            <th style="width:15%">创建时间</th>
                            <th style="width:15%">截止时间</th>
                            <th style="width:10%">分析师</th>
                            <th style="width:15%">状态</th>
                            <th style="width:15%">基本操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tasklist as $task)
                        <tr id="tasklist-{{$task->id}}"  
                        @if($task->status=='doing')
                        class="info"
                        @elseif($task->status=='done')
                        class="success"
                        @elseif($task->status=='canceling')
                        class="warning"
                        @endif
                        >
                            <td>{{$task->name}}</td>
                            <td>{{$task->from_user_name or ''}}</td>
                            <td>{{date('m/d H:i',strtotime($task->created_at))}}</td>
                            <td>{{date('m/d H:i',strtotime($task->deadline))}}</td>
                            <td class="touser">{{$task->to_user_name or ''}}</td>
                            <td class="status">
                                @if($task->status=='doing')
                                    <div class="progress" style="margin:0;">
                                      <div class="progress-bar" style="width: {{$task->progress}}%;min-width: 2em;">
                                        {{$task->progress}}%
                                      </div>
                                    </div>
                                @else
                                    {{$task->getStatus()}}
                                @endif
                            </td>
                            <td class="opration" style="text-align: left;">
                                <a class="btn btn-xs act_info" href="{{route('taskinfo',['id'=>$task->id])}}">详情</a>
                                @if($task->status=='wait')
                                <a class="btn btn-xs act_receive" data-id="{{$task->id}}" data-toggle="modal" data-target="#taskreceive-modal-lg">接受</a>
                                @elseif($task->status=='doing')
                                <a class="btn btn-xs act_hour" data-id="{{$task->id}}" data-toggle="modal" data-target="#taskhour-modal-lg">工时</a>
                                <a class="btn btn-xs act_edit" href="{{route('taskedit',['id'=>$task->id])}}">编辑</a>
                                @elseif($task->status=='canceling')
                                <a class="btn btn-xs act_cancel" data-id="{{$task->id}}">同意</a>
                                <a class="btn btn-xs act_nocancel" data-id="{{$task->id}}">拒绝</a>
                                @elseif($task->status=='done')
                                <a class="btn btn-xs act_edit" href="{{route('taskedit',['id'=>$task->id])}}">编辑</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="taskreceive-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">任务接受</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">请与需求方沟通后接取该任务</div>
                    <form id="taskreceive-form">
                        <input type="hidden" id="taskreceive-id" name="id" value="" readonly/>
                        <div class="form-group form-inline">
                            <div class="input-group">
                                <label class="input-group-addon">预计工时</label>
                                <input type="number" class="form-control" size="15" name="estimate" value="3"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="taskreceive-submit">接受</button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="taskhour-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">工时设置</h4>
                </div>
                <div class="modal-body">
                    <form id="taskhour-form">
                        <input type="hidden" id="taskhour-id" name="id" value="" readonly/>
                        <div class="form-group form-inline">
                                <div class="input-group date form_date"  data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd" >
                                    <span class="input-group-addon">工作日期</span>
                                    <input class="form-control" id="taskhour-logtime" name="logtime" size="15" type="text" value="{{date('Y-m-d')}}" autocomplete="off" readonly />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <div class="input-group">
                                    <label class="input-group-addon">花费工时</label>
                                    <input type="number" class="form-control" id="taskhour-consumed" size="15" name="consumed" />
                                </div>
                                <div class="input-group">
                                    <label class="input-group-addon">预计剩余</label>
                                    <input type="number" class="form-control" id="taskhour-left" size="15" name="left" value="1"/>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="taskhour-desc" class="control-label ">成果描述</label>
                            <textarea class="form-control" rows="3" name="desc" id="taskhour-desc"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="taskhour-submit">设置</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function(){
            var table=$('#tasklist').DataTable({
                lengthChange:true,
                order:[],
                "aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "全部"]],
                "iDisplayLength":-1,
                select:{style:'single'}
            });
            $('.act_nocancel').click(function(){
                var that=this;
                var id=$(that).data('id');
                $.ajax({
                    url:'{{route('posttaskcancel')}}',
                    method:'post',
                    data:{id:id,reject:'yes'},
                    error:function(){
                        alert('似乎出了点问题');
                    },
                    success:function(d){
                        if('progress' in d){
                            var row=table.row($('#tasklist-'+id)).node();
                            $(row).removeClass('warning').addClass('info');
                            $(row).children('td.status').html(
                                    '<div class="progress" style="margin:0;">'+
                                      '<div class="progress-bar" role="progressbar" style="width: '+d['progress']+'%;min-width: 2em;">'+
                                        '<span>'+d['progress']+'%</span>'+
                                      '</div>'+
                                    '</div>'
                                );
                            $(row).children('td.touser').text('{{Auth::user()->name}}');
                            $(row).children('td.opration').html(
                                '<a class="btn btn-xs act_info" href="{{route('taskinfo')}}?id='+ id+'">详情</a>\r\n'+
                                '<a class="btn btn-xs act_hour" data-id="'+ id+'" data-toggle="modal" data-target="#taskhour-modal-lg">工时</a>\r\n'+
                                '<a class="btn btn-xs act_edit" href="{{route('taskedit')}}?id='+ id+'">编辑</a>'
                                );
                            $('.act_hour').click(function(){
                                $('#taskhour-id').val($(this).data('id'));
                                var name=$(this).parents('tr').children('td:first').text();
                                $('#taskhour-modal-lg').find('.modal-title').text(name+'-工时设置');
                                return true;
                            });
                        }
                    }
                });
            });
            $('.act_cancel').click(function(){
                if(!confirm('同意需求方终止该数据需求吗？')){
                    return 0;
                }
                var that=this;
                $.ajax({
                    url:'{{route('posttaskcancel')}}',
                    method:'post',
                    data:{id:$(that).data('id')},
                    error:function(){
                        alert('似乎出了点问题');
                    },
                    success:function(d){
                        if(d>0){
                            var row=table.row($(that).parents('tr')).node();
                            $(row).removeClass('warning');
                            $(row).children('td.status').text('已取消');
                            $(that).remove();
                        }
                    }
                });
            });
            $('#taskreceive-submit').click(function(){
                var id=$('#taskreceive-id').val();
                $.ajax({
                    url:'{{route('posttaskreceive')}}',
                    method:'post',
                    data:$('#taskreceive-form').serialize(),
                    error:function(){
                        alert('似乎出了点问题');
                    },
                    success:function(d){
                        $('#taskreceive-modal-lg').modal('hide');
                        if(d>0){
                            var row=table.row($('#tasklist-'+id)).node();
                            $(row).addClass('info');
                            $(row).children('td.status').html(
                                    '<div class="progress" style="margin:0;">'+
                                      '<div class="progress-bar" role="progressbar" style="width: 0%;min-width: 2em;">'+
                                        '<span>0%</span>'+
                                      '</div>'+
                                    '</div>'
                                );
                            $(row).children('td.touser').text('{{Auth::user()->name}}');
                            $(row).children('td.opration').html(
                                '<a class="btn btn-xs act_info" href="{{route('taskinfo')}}?id='+ id+'">详情</a>\r\n'+
                                '<a class="btn btn-xs act_hour" data-id="'+ id+'" data-toggle="modal" data-target="#taskhour-modal-lg">工时</a>\r\n'+
                                '<a class="btn btn-xs act_edit" href="{{route('taskedit')}}?id='+ id+'">编辑</a>'
                                );
                            $('.act_hour').click(function(){
                                $('#taskhour-id').val($(this).data('id'));
                                var name=$(this).parents('tr').children('td:first').text();
                                $('#taskhour-modal-lg').find('.modal-title').text(name+'-工时设置');
                                return true;
                            });
                        }
                    }
                });
            });
            $('.act_receive').click(function(){
                $('#taskreceive-id').val($(this).data('id'));
                var name=$(this).parents('tr').children('td:first').text();
                $('#taskreceive-modal-lg').find('.modal-title').text(name+'-接受设置');
                return true;
            });
            $('.act_hour').click(function(){
                $('#taskhour-id').val($(this).data('id'));
                var name=$(this).parents('tr').children('td:first').text();
                $('#taskhour-modal-lg').find('.modal-title').text(name+'-工时设置');
                return true;
            });
            $('#taskhour-submit').click(function(){
                $.ajax({
                    url:'{{route('posttaskhour')}}',
                    method:'post',
                    data:$('#taskhour-form').serialize(),
                    error:function(){
                        alert('似乎出了点问题');
                    },
                    success:function(data){
                        if(data['errors']){
                            alert('请填写所有内容');
                        }else{
                            $('#taskhour-modal-lg').modal('hide');
                            var id=$('#taskhour-id').val();
                            $('#tasklist-'+id).find('div.progress-bar').css('width',data+'%').text(data+'%');
                        }
                    }
                });
            });
        });
    </script>
@endsection
