<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LogViewer</title>
    <meta name="description" content="LogViewer">
    <meta name="author" content="ARCANEDEV">
    <link rel="stylesheet" href="{{asset('statics/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('statics/Font-Awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('statics/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    @include('log-viewer::_template.style')
    <!--[if lt IE 9]>
    <script src="{{asset('statics/bootstrap/js/html5shiv.js')}}"></script>
    <script src="{{asset('statics/jquery/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body>
    @include('log-viewer::_template.navigation')

    <div class="container-fluid">
        @yield('content')
    </div>

    @include('log-viewer::_template.footer')

    <script src="{{asset('statics/jquery/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('statics/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('statics/moment/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('statics/chart/chart.min.js')}}"></script>
    <script src="{{asset('statics/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        Chart.defaults.global.responsive      = true;
        Chart.defaults.global.scaleFontFamily = "'Source Sans Pro'";
        Chart.defaults.global.animationEasing = "easeOutQuart";
    </script>
    @yield('scripts')
</body>
</html>
