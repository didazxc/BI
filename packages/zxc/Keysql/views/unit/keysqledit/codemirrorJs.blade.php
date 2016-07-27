    <script type="text/javascript" language="javascript">
        function codeMirror(id) {
            var editor = CodeMirror.fromTextArea(document.getElementById(id), {
                mode: 'text/x-sql',
                styleActiveLine: true,
                indentWithTabs: true,
                smartIndent: true,
                lineNumbers: true,
                matchBrackets: true,
                autofocus: true,
                extraKeys: {
                    "Ctrl-Space": "autocomplete",
                    "F11": function (cm) {
                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                        $('header').toggle();
                        $('aside').toggle();
                    }
                }
            });
            return editor;
        }
        var editor = codeMirror('sqlstr');
        var key_id_json_editor = codeMirror('key_id_json');
        var var_json_editor = codeMirror('var_json');
        var echart_json_editor = codeMirror('echart_json');
        var echart_js_editor = codeMirror('echart_js');
        var wx_str_editor = codeMirror('wx_str');
    </script>