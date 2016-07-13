
    <script src="{{asset('statics/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('statics/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}"></script>
    <script type="text/javascript">
        
            //datetimepicker
            $('.form_date').datetimepicker({
                language: 'zh-CN',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0
            });
            $('.form_datetime').datetimepicker({
                language: 'zh-CN',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 0,
                forceParse: 0
            });
        
    </script>