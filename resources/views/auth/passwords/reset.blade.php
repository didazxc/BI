@extends('auth.default')

@section('content')
	<div class="container-fluid" id="content">
		<div class="row-fluid">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default" id="panel">
					<div class="panel-heading text-center">修改密码</div>
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

						<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="token" value="{{ $token }}">

							<div class="form-group">
								<div class="input-group col-md-offset-1 col-md-10">
									<span class="input-group-addon" id="email-addon">
										<i class="fa fa-envelope"></i>
									</span>
									<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="邮箱地址" aria-describedby="email-addon">
								</div>
							</div>

							<div class="form-group">
								<div class="input-group col-md-offset-1 col-md-10">
									<span class="input-group-addon" id="password-addon">
										<i class="fa fa-key"></i>
									</span>
									<input type="password" class="form-control" name="password" placeholder="新密码" aria-describedby="password-addon">
								</div>
							</div>

							<div class="form-group">
								<div class="input-group col-md-offset-1 col-md-10">
									<span class="input-group-addon" id="password-conf-addon">
										<i class="fa fa-key"></i>
									</span>
									<input type="password" class="form-control" name="password_confirmation" placeholder="密码确认" aria-describedby="password-conf-addon">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-1 col-md-10" id="login-btn">
									<button type="submit" class="btn btn-primary btn-block">修改密码</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
