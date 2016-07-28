@extends('keysql::home.home')

@section('content')
    <div class="container-fluid">
    <div class="row">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">预警信息列表</h3>
            <div class="box-tools pull-right">
                <div id="daterange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                    <span>{{$startdate}} 至 {{$enddate}}</span> <b class="caret"></b>
                </div>
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="table" class="table table-hover">
                <thead>
                <tr><th>严重程度</th><th>预警周期</th><th>汇报时间</th><th>预警内容</th></tr>
                </thead>
                <tbody>
                @foreach($alertlist as $alert)
                <tr>
                    <td>
                        <i class="fa {{$alert->script->faicon?$alert->script->faicon:'fa-warning'}} text-{{$alert->color}}">{{$alert->pro}}</i>
                    </td>
                    <td>
                        <span>{{$alert->cronname}}</span>
                    </td>
                    <td>
                        <small class="pull-right"><i class="fa fa-clock-o">&nbsp;</i>{{date('m-d H:i',strtotime($alert->logtime))}}</small>
                    </td>
                    <td>
                        <span>{{$alert->alert_desc}}</span>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    </div>
@endsection

@section('script')
<script>
    function cb(start, end) {
        window.location.href="{{route('alertlist')}}?startdate="+start.format('YYYY-MM-DD')+"&enddate="+end.format('YYYY-MM-DD');
    }
    $('#daterange').daterangepicker({
            startDate: '{{$startdate}}',
            endDate: '{{$enddate}}',
            showDropdowns: true,
            ranges: {
               '今天': [moment(), moment()],
               '昨天': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               '近7天': [moment().subtract(6, 'days'), moment()],
               '近30天': [moment().subtract(29, 'days'), moment()],
               '本月': [moment().startOf('month'), moment().endOf('month')],
               '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                "format": "YYYY-MM-DD",
                "separator": " 至 ",
                "applyLabel": "确认",
                "cancelLabel": "取消",
                "fromLabel": "起",
                "toLabel": "止",
                "customRangeLabel": "自定义",
                "weekLabel": "周"
            }
        },cb);
    $(document).ready(function() {
        $('#table').DataTable({
            lengthChange: false,
            destory:true,
            scrollX: true,
            scrollY: "300px",
            paging: false,
        });
    });
</script>
@endsection
