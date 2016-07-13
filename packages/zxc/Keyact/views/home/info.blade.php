@extends('keytask::_layouts.default')

@section('content')
    <div class="container">
		<ul class="nav nav-tabs">
		  <li role="presentation" class="active"><a href="#info_tab" role="tab" data-toggle="tab">基本信息</a></li>
		  <li role="presentation"><a href="#offline_intro_tab" role="tab" data-toggle="tab">结案说明</a></li>
		</ul>
		<br/>
        <div class="row">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="info_tab">
					<div class="form-inline">
						<div class="input-group">
							<span class="input-group-addon">名称</span>
							<input class="form-control" type="text" name="act_name" value="{{$act->act_name}}" readonly>
						</div>
						<div class="input-group">
							<span class="input-group-addon">类型</span>
							<input class="form-control" type="text" name="pattern" value="{{$act->pattern}}" readonly>
						</div>
                    </div>
                    <br/>
                    <div class="form-inline">
						<div class="input-group">
							<span class="input-group-addon">上线时间</span>
							<input class="form-control" name="online_time" size="15" type="text" value="{{$act->online_time or ''}}" autocomplete="off" readonly />
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon">下线时间</span>
							<input class="form-control" name="offline_time" size="15" type="text" value="{{$act->offline_time or ''}}" autocomplete="off" readonly />
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
					<br/>
					<label for="online_intro" class="control-label">目标设置:</label>
						<table id="goal" class="table table-hover table-bordered table-condensed text-center">
							<thead><tr><td>指标</td><td>方式</td><td>数值</td></tr></thead>
							<tbody>
							@foreach($act->goal as $k=>$v)
								<tr>
									<td>{{$v['key']}}</td>
									<td>{{$v['type']}}</td>
									<td>{{$v['value']}}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					<br/>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">上线说明</h3>
						</div>
						<div class="panel-body">
							<div class="ueditor" id="online_intro">{!!$act->online_intro!!}</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="offline_intro_tab">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="ueditor" id="offline_intro">{!!$act->offline_intro!!}</div>
						</div>
					</div>
				</div>
			</div>
				
		</div>
    </div>
@endsection


@section('script')
<script type="text/javascript">
	$(function(){
		setTimeout(function(){
			uParse('#online_intro',{
				rootPath: '/packages/zxc/keytask/ueditor/utf8-php/'
			});
			uParse('#offline_intro',{
				rootPath: '/packages/zxc/keytask/ueditor/utf8-php/'
			});
		},300);
	});
</script>
@endsection