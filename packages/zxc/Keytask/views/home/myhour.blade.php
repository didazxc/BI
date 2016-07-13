@extends('keytask::_layouts.default')



@section('content')
    <div class="container-fluid">
        <div class="row">
            <form class="report-form col-sm-12 form-inline" id="report-form" method="get" >
                    <div class="form-group">
                            <div class="input-group date form_date"  data-date="{{Request::input('startdate',date('Y-m-d',strtotime('-7 day')))}}" data-date-format="yyyy-mm-dd" >
                                <span class="input-group-addon">起始</span>
                                <input class="form-control" name="startdate" size="15" type="text" value="{{Request::input('startdate',date('Y-m-d',strtotime('-7 day')))}}" autocomplete="off" readonly />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        <div class="input-group date form_date"  data-date="{{Request::input('enddate',date('Y-m-d'))}}" data-date-format="yyyy-mm-dd" >
                            <span class="input-group-addon">结束</span>
                            <input class="form-control" name="enddate" size="15" type="text" value="{{Request::input('enddate',date('Y-m-d'))}}" autocomplete="off" readonly />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                <input type="submit" id="submit" class="btn btn-primary form-group" value="提交查询">
            </form>
        </div>
        <hr/>
        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" href="#taskhour-logtime-panel">每日总工时</div>
                    <div class="panel-body panel-collapse collapse in" id="taskhour-logtime-panel">
                        <table id="taskhour-logtime-list" class="table table-hover table-striped table-bordered table-condensed text-center">
                            <thead>
                            <tr>
                                <th>日期</th>
                                <th>耗时</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($myhours_logtime as $hour)
                                <tr>
                                    <td>{{$hour->logtime}}</td>
                                    <td>{{$hour->consumed}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" href="#taskhour-task-panel">分任务工时记录</div>
                    <div class="panel-body panel-collapse collapse in" id="taskhour-task-panel">
                        <table id="taskhour-task-list" class="table table-hover table-striped table-bordered table-condensed text-center">
                            <thead>
                            <tr>
                                <th>任务</th>
                                <th>耗时</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($myhours_task as $hour)
                                <tr>
                                    <td>{{$hour->task->name}}</td>
                                    <td>{{$hour->consumed}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" href="#taskhour-panel">工时记录</div>
                        <div class="panel-body panel-collapse collapse in" id="taskhour-panel">
                            <div class="text-center">
                                <div class="col-sm-4">累计总工时：{{$sum_consumed}}</div>
                                <div class="col-sm-4">累计任务数：{{$sum_task_id}}</div>
                                <div class="col-sm-4">累计总天数：{{$sum_logtime}}</div>
                            </div>
                            <hr/>
                            <table id="taskhour-list" class="table table-hover table-striped table-bordered table-condensed text-center">
                                <thead>
                                    <tr>
                                        <th>日期</th>
                                        <th>任务</th>
                                        <th>耗时</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($myhours as $hour)
                                    <tr>
                                        <td>{{$hour->logtime}}</td>
                                        <td>{{$hour->task->name}}</td>
                                        <td>{{$hour->consumed}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(function(){

    })
</script>
@endsection