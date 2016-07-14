@extends('keytask::_layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" href="#taskhour-panel">任务描述</div>
                    <div class="panel-body panel-collapse collapse in" id="taskhour-panel">

                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr><th colspan="6">创建信息</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>任务名称:</td><td colspan="3">{{$task->name}}</td>
                                    <td>创建日期:</td><td>{{$task->created_at}}</td>
                                </tr>
                                <tr>
                                    <td>创建者:</td><td>{{$task->from_user_name}}</td>
                                    <td>优先级:</td><td>{{$task->pri}}</td>
                                    <td>截至日期:</td><td>{{$task->deadline}}</td>
                                </tr>
                                <tr>
                                    <td>任务描述:</td><td colspan="5"><div class="text">{{$task->desc}}</div></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                            <tr><th colspan="6">完成情况</th></tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>指派给:</td><td>{{$task->to_user_name or ''}}</td>
                                <td>接口人:</td><td>{{$task->join_user_name or ''}}</td>
                                <td>当前状态:</td><td>{{$task->status}}</td>
                            </tr>
                            <tr>
                                <td>预计工时:</td><td>{{$task->estimate}}</td>
                                <td>已消耗:</td><td>{{$task->consumed}}</td>
                                <td>预计剩余:</td><td>{{$task->left}}</td>
                            </tr>
                            <tr>
                                <td>完成进度:</td>
                                <td colspan="5">
                                    <div class="progress" style="margin: 0;">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{$task->progress}}" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: {{$task->progress}}%;">
                                            {{$task->progress}}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr><td>当前结果:</td><td colspan="5">{{$task->result}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" href="#taskhour-panel">操作历史</div>
                    <div class="panel-body panel-collapse collapse in" id="taskhour-panel">
                        <table id="taskhour-list" class="table table-hover table-striped table-bordered table-condensed text-center">
                            <thead>
                                <tr>
                                    <th>日期</th>
                                    <th>用户</th>
                                    <th>操作</th>
                                    <th>耗时</th>
                                    <th>剩余</th>
                                    <th>描述</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taskhours as $hour)
                                    <tr data-hourid="{{$hour->id}}">
                                        <td>{{$hour->logtime}}</td>
                                        <td>{{$hour->user_name}}</td>
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
                        <div class="col-sm-6 hide" id="taskhour-del0">
                            <button class="btn btn-danger col-sm-12 taskhour-set" id="taskhour-del">删除记录</button>
                        </div>
                        <div class="col-sm-12" id="taskhour-set0">
                            <button class="btn btn-primary col-sm-12 taskhour-set" id="taskhour-set" data-toggle="modal" data-target="#taskhour-modal-lg">增加工时</button>
                        </div>
                    </div>

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
                        <input type="hidden" id="taskhour-id" name="id" value="{{$taskid}}" readonly/>
                        <input type="hidden" id="taskhour-hourid" name="hourid" value="" readonly/>
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
                                <input type="number" class="form-control" id="taskhour-left" size="15" name="left" />
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
        var table=$('#taskhour-list').DataTable({
            lengthChange:true,
            "aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "全部"]],
            "iDisplayLength":10,
            select:{style:'single'}
        });
        table.on('select',function(e, dt, type, indexes){
            var data = table.rows(indexes).data();
            var datanode = table[ type ]( indexes ).nodes().to$();
            var nodes = datanode.children('td');
            var hourid=datanode.data('hourid');
            $('#taskhour-hourid').val(hourid);
            $('#taskhour-logtime').val(data[0][0]);
            $('#taskhour-consumed').val(Number(data[0][3]));
            $('#taskhour-left').val(Number(data[0][4]));
            $('#taskhour-desc').val(nodes[5].textContent.replace(/(^\s*)|(\s*$)/g, ""));
            $('#taskhour-set0').removeClass('col-sm-12').addClass('col-sm-6');
            $('#taskhour-set').text('工时修改');
            $('#taskhour-del0').removeClass('hide');
        }).on('deselect',function(e, dt, type, indexes){
            $('#taskhour-hourid').val('');
            $('#taskhour-logtime').val('');
            $('#taskhour-consumed').val('');
            $('#taskhour-left').val('');
            $('#taskhour-desc').val('');
            $('#taskhour-set0').removeClass('col-sm-6').addClass('col-sm-12');
            $('#taskhour-set').text('增加工时');
            $('#taskhour-del0').addClass('hide');
        });
        $('#taskhour-submit').click(function(){
			$("#loader").fadeIn();
            $(".mask").fadeIn();
            $.ajax({
                url:'{{route('postHour')}}',
                type:'post',
                data:$('#taskhour-form').serialize(),
                error:function(data){
					$("#loader").fadeOut(300);
                    $(".mask").fadeOut(300);
                    if(!data){
                        alert('connection error!');
                    }else{
                        alert(data['responseText']);
                    }
                },
                success:function(task){
                    location.reload();
                }
            });
        });
        $('#taskhour-del').click(function(){
            var hourid= $('#taskhour-hourid').val();
            var truthDel = window.confirm("确定要删除该条记录吗，删除后不可恢复。");
            if (truthDel) {
				$("#loader").fadeIn();
                $(".mask").fadeIn();
                $.ajax({
                    url: '{{route('postDelHour')}}',
                    type: 'post',
                    data: {hourid: hourid},
                    error: function (data) {
						$("#loader").fadeOut(300);
                        $(".mask").fadeOut(300);
                        if (!data) {
                            alert('connection error!');
                        } else {
                            alert(data['responseText']);
                        }
                    },
                    success: function () {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection