<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>齐齐互动数据后台v2.0</title>
    <link rel="stylesheet" href="/statics/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/statics/Font-Awesome/css/font-awesome.min.css">


    <link rel="stylesheet" href="/css/login.css">
    <!-- [if lt IE 9]>
    <script type="text/javascript" src="/static/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="/static/bootstrap/js/html5shiv.js"></script>
    <![endif] -->
    <!-- [if gte IE 9]><!-->
    <script type="text/javascript" src="/statics/jquery/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="/statics/bootstrap/js/bootstrap.min.js"></script>
    <!-- <![endif]-->

</head>
<body>
        @yield('content')
</body>
</html>