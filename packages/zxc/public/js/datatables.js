//是否存在指定变量
function isExitsVariable(variableName) {
    try {
        if (typeof(variableName) == "undefined") {
            //alert("value is undefined");
            return false;
        } else {
            //alert("value is true");
            return true;
        }
    } catch (e) {
    }
    return false;
}

/**
 * formatMoney(s,type)
 * 功能：金额按千位逗号分割
 * 参数：s，需要格式化的金额数值.
 * 参数：type,判断格式化后的金额是否需要小数位.
 * 返回：返回格式化后的数值字符串.
 */
function formatMoney(s, type, dec) {
    if (/[^0-9\.]/.test(s))
        return "0";
    if (s == null || s == "")
        return "0";
    s = s.toString().replace(/^(\d*)$/, "$1.");
    s = (s + "00").replace(/(\d*\.\d\d)\d*/, "$1");
    s = s.replace(".", ",");
    var re = /(\d)(\d{3},)/;
    while (re.test(s))
        s = s.replace(re, "$1,$2");
    s = s.replace(/,(\d\d)$/, ".$1");
    if (type == 0) {// 不带小数位(默认是有小数位)
        var a = s.split(".");
        if (a[1] == "00") {
            s = a[0];
        }
    }
    if (dec) {
        s = s.replace(/,/g, dec);
    }
    return s;
}
//dataTables默认配置
$.fn.dataTable.defaults.oLanguage = {
    "sEmptyTable": "表中数据为空",
    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
    "sInfoPostFix": "",
    "sDecimal": "",
    "sThousands": ",",
    "sLengthMenu": "显示 _MENU_ 项结果",
    "sLoadingRecords": "载入中...",
    "sProcessing": "处理中...",
    "sSearch": "搜索:",
    "sSearchPlaceholder": "",
    "sUrl": "",
    "sZeroRecords": "没有匹配结果...",
    "sInfoThousands": ",",
    "oPaginate": {
        "sFirst": "首页",
        "sPrevious": "上页",
        "sNext": "下页",
        "sLast": "末页",
        "_hungarianMap": {"first": "sFirst", "last": "sLast", "next": "sNext", "previous": "sPrevious"}
    },
    "oAria": {
        "sSortAscending": ": 以升序排列此列",
        "sSortDescending": ": 以降序排列此列",
        "_hungarianMap": {"sortAscending": "sSortAscending", "sortDescending": "sSortDescending"}
    },
    buttons: {
        copyTitle: '复制到剪切版',
        copyKeys: '按住 <i>ctrl</i> 或 <i>\u2318</i> + <i>C</i> 以复制表中数据到系统剪切版. <br><br>若取消, 点击此框或按Esc键.',
        colvis: '列筛选',
        copySuccess: {
            _: '复制了 %d 行'
        }
    },
    "_hungarianMap": {
        "aria": "oAria",
        "paginate": "oPaginate",
        "emptyTable": "sEmptyTable",
        "info": "sInfo",
        "infoEmpty": "sInfoEmpty",
        "infoFiltered": "sInfoFiltered",
        "infoPostFix": "sInfoPostFix",
        "decimal": "sDecimal",
        "thousands": "sThousands",
        "lengthMenu": "sLengthMenu",
        "loadingRecords": "sLoadingRecords",
        "processing": "sProcessing",
        "search": "sSearch",
        "searchPlaceholder": "sSearchPlaceholder",
        "url": "sUrl",
        "zeroRecords": "sZeroRecords"
    }
};
$.fn.dataTable.defaults.select = {style: 'os'};
$.fn.dataTable.defaults.bDestory = true;
$.fn.dataTable.defaults.ScrollCollapse = true;

//dataTables生成函数
var datatable = function (id, option) {
    if (!arguments[1]) option = {};
    var opt={
        lengthChange: false,
        destory:true,
        scrollX: true,
        scrollY: "300px",
        paging: false,
        fixedColumns: true,
        buttons: ['copy','excel','colvis',{
                extend: 'collection',
                text: '计算',
                buttons: [
                    {
                        text: '均值',
                        action: function ( e, dt, node, config ) {
                            var str='';
                            dt.columns().iterator('column',function( c, i){
                                var avg=dt.column(i).data().reduce(function(a,b){return parseFloat(a)+parseFloat(b);});
                                avg=avg/dt.column(i).data().length;
                                avg=formatMoney(avg);
                                var title = dt.column(i).header();
                                str+=$(title).html()+'：'+avg+'\n';
                            });
                            alert(str);
                        }
                    },
                    {
                        text: '求和',
                        action: function ( e, dt, node, config ) {
                            var str='';
                            dt.columns().iterator('column',function( c, i){
                                var sum=dt.column(i).data().reduce(function(a,b){return parseFloat(a)+parseFloat(b);});
                                sum=formatMoney(sum);
                                var title = dt.column(i).header();
                                str+=$(title).html()+'：'+sum+'\n';
                            });
                            alert(str);
                        }
                    }
                ]
            }]
    };
    option=$.extend(opt,option);
    var table = $('#' + id).DataTable(option);
    table.buttons().container()
        .appendTo( '#'+ id +'_wrapper .col-sm-6:eq(0)' );
    return table;
}
//dataTables的ajax更新函数
var datatable_ajax = function (id, res, obj) {
    if (!isExitsVariable(obj)) {
        obj={};
        //obj['order'] = [[0, "desc"]];
    }
    var dt2 = $('#' + id).DataTable();
    $('#'+ id +'_wrapper').empty();
    dt2.clear();
    dt2.destroy();
    $('#' + id).empty();
    obj['data'] = res['data'];
    obj['columns'] = res['columns'];
    var dt = datatable(id, obj);
    return dt;
}
//辅助函数datatables数据源转echarts数据源
var td2ec_data = function (res) {
    var data = res['data'];
    var columns = res['columns'];
    //整理指标
    var data_obj = {};
    for (var k in columns) {
        eval("data_obj." + columns[k]['data'] + "=[]");
    }
    //整理数据
    for (var i in data) {
        for (var k in columns) {
            var num = data[i][columns[k]['data']];
            data_obj[columns[k]['data']].push(num);
        }
    }
    return data_obj;
}