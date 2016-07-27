    @if($echarts)
    <script type="text/javascript">
        @foreach($echarts as $k=>$echart)
            @if($echart['chart_type']=='echarts')
                var echart_{{$k}} = echarts.init(document.getElementById('echart_{{$k}}'));
            @endif
        @endforeach
        if(transitionEvent){
            var x = document.getElementById("sidebar");
            x.addEventListener(transitionEvent, function() {
                @foreach($echarts as $k=>$echart)
                    @if($echart['chart_type']=='echarts')
                        echart_{{$k}}.resize();
                    @endif
                @endforeach
            });
        };
        
        var echartsvendor=function(rawdata){
            if(rawdata){
                var data=td2ec_data(rawdata);
                            
                {!! $echartjs !!};
                            
                @foreach($echarts as $k=>$echart)
                    @if($echart['chart_type']=='infobox')
                        $('#box_{{$k}} .info-box-number').text(formatMoney({{$echart['data']}}.slice(-1),0));
                        $('#box_{{$k}} .boxchart').sparkline({{$echart['data']}}.slice(-14),{type:"bar",height:"40",barWidth:"4",barSpacing:"1",barColor:"#ffffff",negBarColor:"#eeeeee"});
                    @elseif($echart['chart_type']=='smallbox')
                        $('#box_{{$k}} .info-box-number').text(formatMoney({{$echart['data']}}.slice(-1),0));
                    @elseif($echart['chart_type']=='echarts')
                        echart_{{$k}}.clear();
                        echart_{{$k}}.setOption({{$echart['option']}});
                        echart_{{$k}}.resize();
                    @endif
                @endforeach
            }
        };
    </script>
    @endif