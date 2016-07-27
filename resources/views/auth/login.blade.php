@extends('auth.default')

@section('content')

<div class="container-fluid" id="content">
	<div class="row-fluid">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default" id="panel">
				<div class="panel-heading text-center">用户登录</div>
				<div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>抱歉!</strong> 您的输入有误～
                            <!--<br><br>
							<ul>
								@foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
								@endforeach
                            </ul> -->
                        </div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="input-group col-md-offset-1 col-md-10">
                            <span class="input-group-addon" id="email-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="邮箱" aria-describedby="email-addon">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group col-md-offset-1 col-md-10">
                            <span class="input-group-addon" id="pwd-addon">
                                <i class="fa fa-key"></i>
                            </span>
                                <input type="password" class="form-control" name="password" value="{{ old('email') }}" placeholder="密码" aria-describedby="pwd-addon">
                            </div>
                        </div>

						<div class="form-group">
							<div class="col-md-offset-1 col-md-10">
								<div class="checkbox pull-left">
									<label>
										<input type="checkbox" name="remember"> 记住我
									</label>
								</div>
                                <a class="btn btn-link pull-right" href="{{ url('/password/email') }}">忘记密码？</a>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-1 col-md-10" id="login-btn">
								<button type="submit" class="btn btn-primary btn-block">登录</button>
							</div>
						</div>
					</form>
                    <div class="col-xs-12">
                    <a class="pull-right" href="http://118.26.153.50">>>返回旧版</a>
                    </div>
				</div>
                
			</div>
            
		</div>
	</div>
</div>
@endsection
