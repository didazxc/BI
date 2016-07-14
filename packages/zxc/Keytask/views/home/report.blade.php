@extends('keytask::_layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <form class="report-form col-sm-12 form-inline" id="report-form" method="get" >
                    <div class="form-group">
                            <div class="input-group date form_date"  data-date="{{Request::input('startdate',date('Y-m-d',strtotime('-1 day')))}}" data-date-format="yyyy-mm-dd" >
                                <span class="input-group-addon">起始</span>
                                <input class="form-control" name="startdate" size="15" type="text" value="{{Request::input('startdate',date('Y-m-d',strtotime('-1 day')))}}" autocomplete="off" readonly />
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
            <div class="col-sm-12">
                <table id="taskhour-list" class="table-hover table-bordered table-condensed text-center" style="background-color: #fff;">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>姓名</th>
                        <th>任务</th>
                        <th>耗时</th>
                        <th>进度</th>
                        <th>描述</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($myhours as $hour)
                        <tr>
                            @if($hour->rowspan)
                                <td rowspan="{{$hour->rowspan}}" >{{$hour->logtime}}</td>
                            @endif
                            @if($hour->name_rowspan)
                                <td rowspan="{{$hour->name_rowspan}}" >{{$hour->user_name}}</td>
                            @endif
                            <td>{{$hour->task->name}}</td>
                            <td>{{$hour->consumed}}</td>
                            <td style="width: 10%;">
                                <div class="progress" style="margin: 0;">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{$hour->task->progress}}" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: {{$hour->task->progress}}%;">
                                        {{$hour->task->progress}}%
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%;"><div class="text">{{$hour->task->hourdesc}}</div></td>
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

    })
</script>
@endsection