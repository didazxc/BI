<div class="row">
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">主题选择</span>
                    <select class="form-control" id="select">
                        <option selected>default</option>
                        <option>eclipse</option>
                        <option>midnight</option>
                        <option>monokai</option>
                        <option>vibrant-ink</option>
                        <option>cobalt</option>
                        <option>rubyblue</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4" >
                <button class="btn btn-primary btn-block" id="save">保存信息</button>
            </div>
            <div class="col-sm-4" >
                <a class="btn btn-success btn-block" id="save-preview" href="{{asset(route('getAdminKeysqltest',['id'=>$sql_id]))}}" target="_blank">效果预览</a>
            </div>
        </div><!--/.row-->