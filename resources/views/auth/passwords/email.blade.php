@extends('auth.default')

@section('content')
<div class="container-fluid" id="content">
	<div class="row-fluid">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default" id="panel">
				<div class="panel-heading text-center">忘记密码</div>
				<div class="panel-body">
					@if (session('status'))
						<div class="alert alert-success">
							邮件已发送，链接地址一小时内有效
						</div>
					@endif
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
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
							<div class="col-md-offset-1 col-md-10" id="login-btn">
								<button type="submit" class="btn btn-primary btn-block">发送密码重置链接</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
