<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta name="author" content="ZhangXiaochuan" />
    <meta name="description" content="QiQi BI" />
    <title>齐齐互动数据后台v1.0</title>
    @foreach ($css as $url)
        <link href="{{$url}}" rel="stylesheet" media="screen" />
    @endforeach
    @yield('css')
    <!-- [if lt IE 9]>
    <script type="text/javascript" src="{{asset(\Zxc\Keytask\KeytaskServiceprovider::$public_path.'/jquery/1.11.2/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset(\Zxc\Keytask\KeytaskServiceprovider::$public_path.'/bootstrap/js/html5shiv.js')}}"></script>
    <![endif] -->
    <!-- [if gte IE 9]><!-->
    <script type="text/javascript" src="{{asset(\Zxc\Keytask\KeytaskServiceprovider::$public_path.'/jquery/2.1.3/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset(\Zxc\Keytask\KeytaskServiceprovider::$public_path.'/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- <![endif]-->
</head>
<body>
    @section('mask')
        <!-- Preloader -->
        <div class="mask"><div id="loader"><i class="fa fa-2x fa-spinner fa-pulse"></i></div></div>
        <!--/Preloader -->
    @show
    @section('nav')
        @include('keytask::_layouts.nav')
    @show
    <div id="all-content">
        @section('all-content')
            <div id="content" class="nicescroll">
                @yield('content')
                <div id="footer">
                    ©2015 made by <a href="#">信息组</a>
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

