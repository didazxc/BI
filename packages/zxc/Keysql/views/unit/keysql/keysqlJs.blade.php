    <script type="text/javascript">
        $(function(){
            $('#report-form').submit(function(){
                $("#loader").fadeIn();
                $(".mask").fadeIn();
                formajax();
                return false;
            });
        });
		@if(array_key_exists('_submit',$form))
			@if($form['_submit']['time']==0)
				$("#loader").fadeIn();
				$(".mask").fadeIn();
				formajax();
			@elseif($form['_submit']['type']=='interval')
				formajax();
                window.setInterval(function(){ 
					formajax();
				}, {{intval($form['_submit']['time'])*60*1000}});
			@elseif($form['_submit']['type']=='timeout')
                window.setTimeout(function(){ 
					formajax();
				}, {{intval($form['_submit']['time'])*60*1000}});
			@endif
		@endif
        //提交数据后，重新绘制datatable和echarts
        function formajax(){
                $.ajax({
                    cache: true,
                    type: 'POST',
                    data:$('#report-form').serialize(),
                    url:'{{route($routename,["nav_id"=>$nav_id])}}',
                    async: true,
                    error: function(request) {
                        $("#loader").fadeOut(300);
                        $(".mask").fadeOut(300);
                        alert("Connection error");
                    },
                    success: function(rawdata) {
                        if(rawdata['error']){
                            alert(rawdata['error']);
                        }
                        if(rawdata['columns'].length){
                            var table=datatable_ajax('datatable',rawdata);
                            @if($echarts)
                                echartsvendor(rawdata);
                            @endif
                        }
                        $("#loader").fadeOut(300);
                        $(".mask").fadeOut(300);
                    }
                })
        }
    </script>