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
				<input type="submit" id="submit" class="btn btn-primary" value="需求筛选">
			</form>
            <div class="form-inline col-sm-2">
				<a href="{{route('demandedit')}}" class="btn btn-primary pull-right" >新建需求</a>
            </div>
        </div>
        <hr/>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover table-striped table-bordered table-condensed text-center" id="tasklist" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width:20%">名称</th>
                            <th style="width:15%">创建时间</th>
                            <th style="width:15%">截止时间</th>
                            <th style="width:10%">分析师</th>
                            <th style="width:20%">状态</th>
                            <th style="width:20%">基本操作</th>
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
                            <td>{{date('m/d H:i',strtotime($task->created_at))}}</td>
                            <td>{{date('m/d H:i',strtotime($task->deadline))}}</td>
                            <td>{{$task->to_user->name or ''}}</td>
                            <td>
                                @if($task->status=='doing')
                                    <div class="progress" style="margin:0;">
                                      <div class="progress-bar" role="progressbar" aria-valuenow="{{$task->progress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$task->progress}}%;min-width: 2em;">
                                        <span>{{$task->progress}}%</span>
                                      </div>
                                    </div>
                                @else
                                    {{$task->getStatus()}}
                                @endif
                            </td>
                            <td style="text-align: left;">
                                <a class="btn btn-xs act_info" href="{{route('taskinfo',['id'=>$task->id])}}">详情</a>
                                @if($task->status=='wait')
                                <a class="btn btn-xs" href="{{route('demandedit',['id'=>$task->id])}}">修改</a>
                                <a class="btn btn-xs act_delete" data-id="{{$task->id}}">删除</a>
                                @elseif($task->status=='doing')
                                <a class="btn btn-xs act_cancel" data-id="{{$task->id}}">取消</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
            
            $('.act_delete').click(function(){
                if(!confirm('删除后不可恢复，确认删除吗？')){
                    return 0;
                }
                var that=this;
                $.ajax({
                    url:'{{route('postdemanddelete')}}',
                    method:'post',
                    data:{id:$(that).data('id')},
                    error:function(){
                        alert('似乎出了点问题');
                    },
                    success:function(d){
                        if(d>0){
                            table.row($(that).parents('tr')).remove().draw();
                        }else{
                            alert('已无法执行该操作，请刷新页面！');
                        }
                    }
                });
            });
            $('.act_cancel').click(function(){
                if(!confirm('取消需经分析师同意，确认取消吗？')){
                    return 0;
                }
                var that=this;
                $.ajax({
                    url:'{{route('postdemandcancel')}}',
                    method:'post',
                    data:{id:$(that).data('id')},
                    error:function(){
                        alert('似乎出了点问题');
                    },
                    success:function(d){
                        if(d>0){
                            var row=table.row($(that).parents('tr')).node();
                            $(row).removeClass('info').addClass('warning');
                            $(row).find('.progress').parent('td').text('取消中');
                            $(that).remove();
                        }else{
                            alert('已无法执行该操作，请刷新页面！');
                        }
                    }
                });
            });
        });
    </script>
@endsection
