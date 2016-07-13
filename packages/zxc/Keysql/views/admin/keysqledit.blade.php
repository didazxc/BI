@extends('keysql::admin.home')

@section('css')
    @include('keysql::unit.keysqledit.codemirrorCss')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#sql_box" data-toggle="tab">SQL设置</a></li>
                <li role="presentation"><a href="#key_id_json_box" data-toggle="tab">表格设置</a></li>
                <li role="presentation"><a href="#echart_json_box" data-toggle="tab">图形设计</a></li>
                <li role="presentation"><a href="#wx_str_box" data-toggle="tab">引用设置</a></li>
            </ul>
        </div>
        <br/>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="sql_box">
                @include('keysql::unit.keysqledit.sqlBox')
            </div><!--/.tab-pane-->
            <div role="tabpanel" class="tab-pane" id="key_id_json_box">
                @include('keysql::unit.keysqledit.keyidjsonBox')
            </div><!--/.tab-pane-->
            <div role="tabpanel" class="tab-pane" id="echart_json_box">
                @include('keysql::unit.keysqledit.echartjsonBox')
            </div>
            <div role="tabpanel" class="tab-pane" id="wx_str_box">
                @include('keysql::unit.keysqledit.wxstrBox')
            </div>
        </div><!--/.tab-content-->
        <br/>
        @include('keysql::unit.keysqledit.delSection')
    </div>
@endsection

@section('script')
    @include('keysql::unit.keysqledit.codemirrorJs')
    @include('keysql::unit.keysqledit.js')
@endsection
