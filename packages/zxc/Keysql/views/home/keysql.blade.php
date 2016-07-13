@extends('keysql::home.home')

@section('css')
    @include('keysql::unit.keysql.varformCss')
@endsection

@section('content')
    <div class="container-fluid">
    <div class="row">
        @include('keysql::unit.keysql.varformSection')
        <hr class="report-header"/>
        @include('keysql::unit.keysql.echartsSection')
        @include('keysql::unit.keysql.tableSection')
    </div>
    </div>
@endsection

@section('script')
    @include('keysql::unit.keysql.varformJs')
    @include('keysql::unit.keysql.echartsJs')
    @include('keysql::unit.keysql.keysqlJs',['routename'=>'postKeysql'])
@endsection
