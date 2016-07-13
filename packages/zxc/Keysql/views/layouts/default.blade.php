<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{config('keysql.sysname')}}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
       
        
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="{{asset('statics/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('statics/Font-Awesome/css/font-awesome.min.css')}}">
        <!-- Ion Icons -->
        <link rel="stylesheet" href="{{asset('statics/ionicons/css/ionicons.min.css')}}">
        <!-- AdminLTE 2 -->
        <link rel="stylesheet" href="{{asset('statics/AdminLTE2/dist/css/AdminLTE.min.css')}}">
        <!-- App Setup -->
        <link rel="stylesheet" href="{{asset('packages/zxc/css/app.css')}}">
        
        @section('css_section')
            @yield('css')
        @show
    </head>
    <body class="hold-transition skin-blue sidebar-mini layout-boxed" id="body">
        <!-- Preloader -->
        <div class="mask"><div id="loader"><i class="fa fa-2x fa-spinner fa-pulse"></i></div></div>
        <!--/Preloader -->
        <div class="wrapper">
            @include('keysql::layouts.nav')
            @include('keysql::layouts.sidebar')
            <div class="content-wrapper">
                @section('breadcrumb')
                    @include('keysql::layouts.breadcrumb')
                @show
                <section class="content">
                    @yield('content')
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            @include('keysql::layouts.footer')
            @include('keysql::layouts.controlbar')
        </div><!-- ./wrapper -->
        <!-- jQuery 2.2.4 -->
        <script src="{{asset('statics/jquery/jquery-2.2.4.min.js')}}"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="{{asset('statics/bootstrap/js/bootstrap.min.js')}}"></script>
        
        <!-- AdminLTE 2 -->
        <script src="{{asset('statics/AdminLTE2/dist/js/app.min.js')}}"></script>
        <!-- App Setup -->
        <script src="{{asset('packages/zxc/js/app.js')}}"></script>
        
        @section('script_section')
            @yield('script')
        @show
    </body>
</html>
