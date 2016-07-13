@extends('keytask::_layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form id="taskeditform" action="{{route('postdemandedit')}}" method="post">
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}" readonly>
                  <input type="hidden" name="id" value="{{$task->id}}" readonly>
                  <div class="row">
                      <div class="form-group col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">名称</span>
                            <input type="text" class="form-control" name="name" value="{{$task->name or ''}}">
                        </div>
                      </div>
                      <div class="form-group col-sm-4">
                        <div class="input-group date form_datetime"  data-date="{{$task->deadline or date('Y-m-d H:i')}}" data-date-format="yyyy-mm-dd hh:ii" >
                            <span class="input-group-addon">截止时间</span>
                            <input class="form-control" name="deadline" size="15" type="text" value="{{$task->deadline or date('Y-m-d H:i')}}" autocomplete="off" readonly />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                      <div class="form-group col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">分析师</span>
                            <select class="form-control" name="to_user_id">
                                <option value="0">不指定</option>
                                @foreach($userlist as $id=>$user)
                                    <option value="{{$id}}">{{$user}}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">详细描述</label>
                    <textarea name="desc" id="desc">{{$task->desc or ''}}</textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">提交数据需求</button>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">
        $(function(){
            var ue_desc = UE.getEditor('desc',{
				initialFrameHeight: 300,
			});
            $('#taskeditform').submit(function(){
                $("#loader").fadeIn(300);
				$(".mask").fadeIn(300);
                $.ajax({
                    url:'{{route('postdemandedit')}}',
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
                        }else{
                            window.location.href='{{route('demandlist')}}';
                        }
                    }
                });
                return false;
            });
        });
    </script>
@endsection
