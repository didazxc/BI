<!DOCTYPE html>
<html lang="zh-CN">
<body>

<script type="text/javascript">

    window.onload = function () {
        var data='{{$res}}'.replace(/&quot;/g,'"').replace(/&lt;br\/&gt;/g,'<br/>');
        window.opener.window.postMessage(data, '*');
        window.close();
    };

</script>

<script type="text/javascript">
/*
    window.onmessage = function (m) {
        m = m || event;
        var data=eval('('+m.data+')');
        $('#editArea').empty();
        $("#editArea").html(data['str']);
        var enter = jQuery.Event("keydown");
        enter.ctrlKey = true;
        enter.keyCode = 13;
        $("#editArea").trigger(enter);
        $('a.btn_send').click();
    }

    setInterval(function(){
        open("{{asset('keyalert/wx?cycle=h')}}", "", "fullscreen=1")
    }, 24*60*60*1000);

    //*/
</script>





</body>

</html>

