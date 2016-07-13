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
                                <td colspan="3" id="taskdesc">
                                {!! $task->desc or '' !!}
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
                                    <th>分析师</th><td>{{$task->to_user->name or ''}}</td>
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
                        </div>
					</div>
                    <div class="panel panel-default">
                        <div class="panel-heading" data-toggle="collapse" href="#taskresult-panel">结案详情</div>
                        <div class="panel-body panel-collapse collapse in" id="taskresult-panel">
                        {!!$task->result  or '' !!}
                        </div>
                    </div>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                </div>
			</div>
		</div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">
        $(function(){
            
            uParse('#taskdesc',{
                rootPath : '/packages/zxc/keytask/ueditor/utf8-php/'
            });
            uParse('#taskresult-panel',{
                rootPath : '/packages/zxc/keytask/ueditor/utf8-php/'
            });
        });
        
    </script>
@endsection
