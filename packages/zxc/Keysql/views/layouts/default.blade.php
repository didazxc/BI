<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{config('keysql.sysname')}}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        @foreach($css as $url)
        <link rel="stylesheet" href="{{$url}}">
        @endforeach
        @section('css_section')
            @yield('css')
        @show
        <!-- [if lt IE 9]>
        @foreach ($headjs_ie8 as $url)
            <script src="{{$url}}" type="text/javascript" charset="UTF-8"></script>
        @endforeach
        <![endif] -->
        <!-- [if gte IE 9]><!-->
        @foreach ($headjs as $url)
            <script src="{{$url}}" type="text/javascript" charset="UTF-8"></script>
        @endforeach
        <!-- <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini" id="body">
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
            
        </div><!-- ./wrapper -->
        @foreach($js as $url)
        <script src="{{$url}}"></script>
        @endforeach
        @section('script_section')
            @yield('script')
        @show
    </body>
</html>
