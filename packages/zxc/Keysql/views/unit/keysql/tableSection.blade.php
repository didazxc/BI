        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">数据列表</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="折叠"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="datatable" class="table table-hover table-bordered table-condensed" style="width: 100%;">
                            <thead><tr><th></th></tr></thead>
                        </table>
                    </div>
                </div>
            </div>
            @if($desc_table)
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">字段描述</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="折叠"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table id="datatable2" class="table table-hover table-bordered table-condensed" style="width: 100%;">
                                <thead><tr><th>指标</th><th>描述</th></tr></thead>
                                <tbody>
                                @foreach($desc_table['data'] as $desc)
                                    <tr>
                                        <td>{{$desc['keytag']}}</td>
                                        <td>{{$desc['keydesc']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>