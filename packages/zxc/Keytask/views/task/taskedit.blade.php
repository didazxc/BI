@extends('keytask::_layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs">
              <li role="presentation"><a href="#info_tab" role="tab" data-toggle="tab">需求单</a></li>
              <li role="presentation" class="active"><a href="#result_tab" role="tab" data-toggle="tab">结案反馈</a></li>
              <li role="presentation"><a href="#hour_tab" role="tab" data-toggle="tab">工时记录</a></li>
            </ul>
        </div>
		<br/>
        <div class="row">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane" id="info_tab">
                    <table class="table table-bordered">
                        <thead>
                            <tr><th colspan="4"><h4>数据查询与分析需求申请单</h4></th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>需求名称：</th>
                                <td>{{$task->name}}</td>
                                <th>申请人：</th>
                                <td>{{$task->from_user->name}}</td>
                                
                            </tr>
                            <tr>
                                <th>下单时间：</th>
                                <td>{{$task->created_at}}</td>
                                <th>截止时间：</th>
                                <td>{{$task->deadline}}</td>
                            </tr>
                            <tr>
                                <th>详细说明：</th>
                                <td colspan="3">
                                {!! $task->desc !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
				<div role="tabpanel" class="tab-pane active" id="result_tab">
					<div class="panel panel-default">
                        <div class="panel-heading" data-toggle="collapse" href="#taskinfo-panel">任务描述</div>
						<div class="panel-body panel-collapse collapse in" id="taskinfo-panel">
							<table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>开始时间</th><td>{{$task->starttime}}</td>
                                    <th>结束时间</th><td>{{$task->endtime}}</td>
                                </tr>
                                <tr>
                                    <th>优先级</th><td>{{$task->pri}}</td>
                                    <th>截止时间</th><td>{{$task->deadline}}</td>
                                </tr>
                                <tr>
                                    <th>预计工时</th><td>{{$task->estimate}}</td>
                                    <th>已耗工时</th><td>{{$task->consumed}}</td>
                                </tr>
                                <tr>
                                    <th>预计剩余</th><td>{{$task->left}}</td>
                                    <th>当前状态</th><td>
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
                                </tr>
                            </tbody>
                            </table>
                            <br/>
                            @if($task->status=='doing')
                            <div class="alert alert-info">如果任务完结，请点击完成该任务，完成任务后将不再记录工时，但仍然可以修改结案。</div>
                            <button class="btn btn-primary pull-right" id="taskdone">完成该任务</button>
                            @endif
                        </div>
					</div>
                    <form class="form" id="taskeditform">
                        <label for="result" class="control-label">结案编辑</label>
                        <input type="hidden" name="id" value="{{$task->id}}" readonly>
                        <textarea class="ueditor" id="result" name="result">{!!$task->result!!}</textarea>
                        <br/>
                        <input type="submit" class="btn btn-primary" value="提交结案编辑">
                    </form>
				</div>
                <div role="tabpanel" class="tab-pane" id="hour_tab">
                    
                            <table id="taskhour-list" class="table table-hover table-striped table-bordered table-condensed text-center">
                                <thead>
                                    <tr>
                                        <th style="width:15%;">日期</th>
                                        <th style="width:10%;">用户</th>
                                        <th style="width:15%;">操作</th>
                                        <th style="width:10%;">耗时</th>
                                        <th style="width:10%;">剩余</th>
                                        <th style="width:30%;">描述</th>
                                        <th style="width:10%;">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($taskhours as $hour)
                                        <tr>
                                            <td>{{$hour->logtime}}</td>
                                            <td>{{$hour->user->name}}</td>
                                            <td>{{$hour->operation}}</td>
                                            <td>{{$hour->consumed}}</td>
                                            <td>{{$hour->left}}</td>
                                            <td>
                                                <div class="text">{{$hour->desc}}</div>
                                            </td>
                                            <td>
                                                <a class="hour_delete btn btn-xs @if($task->status!='doing') disabled @endif " data-id="{{$hour->id}}">删除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($task->status=='doing')
                            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#taskhour-modal-lg">增加工时</button>
                            @endif
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
                        <input type="hidden" id="taskhour-id" name="id" value="{{$task->id}}" readonly/>
                        <input type="hidden" name="hour" value="1" readonly/>
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
            var ue_result = UE.getEditor('result',{
				initialFrameHeight: 300,
			});
            $('#taskeditform').submit(function(){
                $("#loader").fadeIn(300);
				$(".mask").fadeIn(300);
                $.ajax({
                    url:'{{route('posttaskedit')}}',
                    method:'post',
                    data:$('#taskeditform').serialize(),
                    error:function(data){
                        $("#loader").fadeOut(300);
                        $(".mask").fadeOut(300);
                        alert('连接失败');
                    },
                    success:function(data){
                        $("#loader").fadeOut(300);
                        $(".mask").fadeOut(300);
                        if(data['errors']){
                            alert(data['errors']);
                        }
                    }
                });
                return false;
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
                            d=data['keyhour'];
                            $('#taskhour-list tbody').prepend('<tr><td>'+d['logtime']+'</td>\r\n'+
                                            '<td>'+data['username']+'</td>\r\n'+
                                            '<td>'+d['operation']+'</td>\r\n'+
                                            '<td>'+d['consumed']+'</td>\r\n'+
                                            '<td>'+d['left']+'</td>\r\n'+
                                            '<td>\r\n'+
                                                '<div class="text">'+d['desc']+'</div>\r\n'+
                                            '</td>\r\n'+
                                            '<td>\r\n'+
                                                '<a class="hour_delete btn btn-xs @if($task->status!='doing') disabled @endif " data-id="'+d['id']+'">删除</a>\r\n'+
                                            '</td></tr>');
                        }
                    }
                });
            });
            $('.hour_delete').click(function(){
                if(confirm('删除后不可恢复')){
                    var that=this;
                    $.ajax({
                        url:'{{route('taskhourdelete')}}',
                        method:'post',
                        data:{id:$(that).data('id')},
                        error:function(){
                            alert('似乎出了点问题');
                        },
                        success:function(d){
                            $(that).parents('tr').remove();
                        }
                    });
                }
            });
            
            $('#taskdone').click(function(){
                if(!confirm('完成后不能修改工时信息')){
                    return false;
                }
                $.ajax({
                    url:'{{route('posttaskdone')}}',
                    method:'post',
                    data:{id:'{{$task->id}}'},
                    error:function(){
                        alert('似乎出了点问题');
                    },
                    success:function(d){
                        if(d){
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection
