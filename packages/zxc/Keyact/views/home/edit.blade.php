@extends('keytask::_layouts.default')

@section('css')
<style>
	#goal tbody td{
		padding:0;
	}
	td input{
		line-height:2em;
		text-align:center;
		border:none;
		width:100%;
		height:100%;
	}
	.navbar-fixed-top{
		z-index:0;
	}
</style>
@endsection

@section('content')
    <div class="container">
		@if($act->id)
			<h4>编辑事件</h4>
		@else
			<h4>新建事件</h4>
		@endif
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#info_tab" role="tab" data-toggle="tab">基本信息</a></li>
			<li role="presentation"><a href="#offline_intro_tab" role="tab" data-toggle="tab">结案说明</a></li>
		</ul>
		<br/>
        <div class="row">
			<form class="report-form col-sm-12" id="report-form" method="post" action="{{route('postEdit')}}">
				<input type="hidden" name="id" value="{{$act->id or 0}}">
				<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="info_tab">
						<div class="form-inline">
							<div class="input-group">
								<span class="input-group-addon">名称</span>
								<input class="form-control" type="text" name="act_name" value="{{$act->act_name}}">
							</div>
							<div class="input-group">
								<span class="input-group-addon">类型</span>
								<select class="form-control" name="pattern">
									@foreach($act->patternList as $pattern)
										<option @if($pattern==$act->pattern)selected @endif>{{$pattern}}</option>
									@endforeach
								</select>
							</div>
							<div class="input-group date form_datetime"  data-date="{{$act->online_time or date('Y-m-d H:i')}}" data-date-format="yyyy-mm-dd hh:ii" >
								<span class="input-group-addon">上线时间</span>
								<input class="form-control" name="online_time" size="15" type="text" value="{{$act->online_time or date('Y-m-d H:i')}}" autocomplete="off" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<div class="input-group date form_datetime"  data-date="{{$act->offline_time or date('Y-m-d H:i')}}" data-date-format="yyyy-mm-dd hh:ii" >
								<span class="input-group-addon">下线时间</span>
								<input class="form-control" name="offline_time" size="15" type="text" value="{{$act->offline_time or date('Y-m-d H:i')}}" autocomplete="off" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<br/><br/>
						<label class="control-label">目标设置:</label>
						<i>请添加指标</i>
						<button id="addgoal" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
						<table id="goal" class="table table-hover table-bordered table-condensed text-center">
							<thead><tr><td>指标</td><td>评价方式</td><td>数值</td></tr></thead>
							<tbody>
							@if($act->goal)
							@foreach($act->goal as $k=>$v)
								<tr>
									<td><input type="text" name="goal[{{$k}}][key]" value="{{$v['key']}}"></td>
									<td><input type="text" name="goal[{{$k}}][type]" value="{{$v['type']}}"></td>
									<td><input type="text" name="goal[{{$k}}][value]" value="{{$v['value']}}"></td>
								</tr>
							@endforeach
							@else
								<tr>
									<td><input type="text" name="goal[0][key]" ></td>
									<td><input type="text" name="goal[0][type]" ></td>
									<td><input type="text" name="goal[0][value]" ></td>
								</tr>
							@endif
							</tbody>
						</table>
						<br/>
						<label for="online_intro" class="control-label">上线说明:</label>
						<textarea name="online_intro" id="online_intro">{{$act->online_intro}}</textarea>
					</div>
					<div role="tabpanel" class="tab-pane" id="offline_intro_tab">
						<textarea name="offline_intro" id="offline_intro">{{$act->offline_intro}}</textarea>
					</div>
				</div>
				<br/>
				
				<input type="submit" id="submit" class="btn btn-primary col-sm-12" value="提交">
			</form>
		</div>
    </div>
@endsection


@section('script')
<script type="text/javascript">
	$(function(){
		
		$('#addgoal').click(function(){
			var num=$('#goal tbody tr').length+1;
			$('#goal tbody').append('\
			<tr>\
				<td><input type="text" name="goal['+num+'][key]"></td>\
				<td><input type="text" name="goal['+num+'][type]"></td>\
				<td><input type="text" name="goal['+num+'][value]"></td>\
			</tr>\
			');
			return false;
		});
		setTimeout(function(){
			var ue_on = UE.getEditor('online_intro',{
				initialFrameHeight: 300,
			});
			var ue_off = UE.getEditor('offline_intro',{
				initialFrameHeight: 400,
			});
			
		},300);
	});
</script>
@endsection