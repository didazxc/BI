<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta name="author" content="ZhangXiaochuan" />
    <meta name="description" content="QiQi BI" />
    <title>{{config('keytask.sysname')}}</title>
    @foreach ($css as $url)
        <link href="{{$url}}" rel="stylesheet" media="screen" />
    @endforeach
    @yield('css')
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
<body>
    <!-- Preloader -->
    <div class="mask"><div id="loader"><i class="fa fa-2x fa-spinner fa-pulse"></i></div></div>
    <!--/Preloader -->
    @section('nav')
        @include('keytask::_layouts.nav')
    @show
    <div id="all-content">
        @section('all-content')
            @section('sidebar')
                @include('keytask::_layouts.sidebar')
            @show
            <div id="content">
                @yield('content')
                <div id="footer">
                    ©2016 made by <a href="#">信息组</a>
                </div>
            </div>
        @show
    </div>
    <!-- Scripts -->
    @foreach ($js as $url)
        <script src="{{$url}}" type="text/javascript" charset="UTF-8"></script>
    @endforeach
    @yield('script')
</body>
</html>

