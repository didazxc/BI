@extends('keytask::_layouts.default')



@section('content')

    <div class="container">
        <div class="row" >
			<form class="report-form col-sm-8 form-inline" id="report-form" method="get" >
				<div class="form-group">
					<div class="input-group date form_date"  data-date="{{$startdate}}" data-date-format="yyyy-mm-dd" >
						<span class="input-group-addon">起</span>
						<input class="form-control" name="startdate" size="15" type="text" value="{{$startdate}}" autocomplete="off" readonly />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
					<div class="input-group date form_date"  data-date="{{$enddate}}" data-date-format="yyyy-mm-dd" >
						<span class="input-group-addon">止</span>
						<input class="form-control" name="enddate" size="15" type="text" value="{{$enddate}}" autocomplete="off" readonly />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
				<input type="submit" id="submit" class="btn btn-primary form-group" value="提交查询">
			</form>
			<div class="form-inline pull-right">
                <a class="btn btn-primary" href="{{route('actEdit')}}">新建事件</a>
            </div>
		</div>
		<hr class="report-header"/>
		<div class="row">
            <div class="col-sm-12">
                
                    
                        
                            <table id="datatable" class="table table-hover table-bordered table-condensed text-center" style="width: 100%;">
                                <thead>
									<tr>
										<th style="width:24%;">名称</th>
										<th style="width:10%;">类型</th>
										<th style="width:10%;">创建者</th>
										<th style="width:19%;">上线时间</th>
										<th style="width:19%;">下线时间</th>
										<th style="width:18%;">操作</th>
									</tr>
								</thead>
								<tbody>
									@foreach($list as $k=>$row)
										<tr>
											<td>{{$row->act_name}}</td>
											<td>{{$row->pattern}}</td>
											<td>{{$row->username}}</td>
											<td>{{date('Y-m-d H:i',strtotime($row->online_time))}}</td>
											<td>{{date('Y-m-d H:i',strtotime($row->offline_time))}}</td>
											<td>
												<a class="btn btn-xs" href="{{route('actInfo',['id'=>$row->id])}}">详情</a>
												@if(Auth::user()->name==$row->username)
													<a class="btn btn-xs" href="{{route('actEdit',['id'=>$row->id])}}">编辑</a>
													<a class="btn btn-xs postdel" data-id="{{$row->id}}"/>删除</a>
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
		var table=$('#datatable').DataTable({
                lengthChange:true,
                "aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "全部"]],
                "iDisplayLength":-1,
                select:{style:'single'}
            });
		$(".postdel").click(function(){
			var this_row=$(this).parents('tr');
			if(confirm("确定要删除吗？")){
				$("#loader").fadeIn(300);
				$(".mask").fadeIn(300);
				$.ajax({
					cache: true,
					type: 'POST',
					data: {id:$(this).data('id')},
					url:'{{route('postActDel')}}',
					async: true,
					error: function(request) {
						$("#loader").fadeOut(300);
						$(".mask").fadeOut(300);
						alert("Connection error");
					},
					success: function(data) {
						$("#loader").fadeOut(300);
						$(".mask").fadeOut(300);
						table.row(this_row).remove().draw();
					}
				});
			}
			
		});
	});
</script>
@endsection