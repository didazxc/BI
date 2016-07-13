@extends('keysql::layouts.default')

@section('css_section')
        <!-- AdminLTE Skins -->
        <link rel="stylesheet" href="{{asset('statics/AdminLTE2/dist/css/skins/_all-skins.min.css')}}">
        <!-- DataTables 1.10.9 -->
        <link rel="stylesheet" href="{{asset('statics/DataTables/media/css/dataTables.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('statics/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('statics/DataTables/extensions/FixedColumns/css/fixedColumns.bootstrap.min.css')}}">
        @yield('css')
@endsection

@section('script_section')
        <!-- AdminLTE demo -->
        <script src="{{asset('statics/AdminLTE2/dist/js/demo.js')}}"></script>
        <!-- DataTables 1.10.9 -->
        <script src="{{asset('statics/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('statics/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{asset('statics/DataTables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('statics/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js')}}"></script>
        <script src="{{asset('statics/DataTables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js')}}"></script>
        <script src="{{asset('packages/zxc/js/datatables.js')}}"></script>
        @yield('script')
@endsection