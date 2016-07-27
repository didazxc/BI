<?php
namespace Zxc\Keysql\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Zxc\Keysql\Models\KeySqlNav;
use Zxc\Keysql\Models\KeySql;
use Zxc\Keysql\Models\Helper;
use Auth;

class AdminController extends BaseController{

    public function __construct(){
        view()->composer(
            ['keysql::layouts.sidebar','keysql::layouts.breadcrumb'],
            'Zxc\Keysql\Http\ViewComposers\AdminNavComposer');
    }
    
    public function index(){
        return view('keysql::admin.home',['sysname'=>config('keysql.sysname')]);
    }

    public function ajaxData(Request $request){
        if($request->ajax()){
            $navid=$request->input('navid');
            $thisnav=$navid?KeySqlNav::find($navid):[];
            $navlist=KeySqlNav::withDepth()->where('id','<>',$navid)->descendantsOf(1)->toFlatTree();
            $sqllist=KeySql::orderBy('id','desc')->lists('sql_desc','id');
            return compact('thisnav','navlist','sqllist');
        }
    }

    public function getKeysqlnav(Request $request){
        $home_node_id=KeySqlNav::where('name','home')->first()->id;
        $root_id=$request->input('id',$home_node_id);
        $root=KeySqlNav::withDepth()->find($root_id);
        $root_depth=$root->depth;
        $keysql_nav_tree=KeySqlNav::withDepth()->descendantsOf($root_id)->toTree();

        $select_list=[$home_node_id=>'home',2=>'admin',1=>'root'];
        return view('keysql::admin.keysqlnav',compact('keysql_nav_tree','root_depth','select_list','root_id'));
    }

    public function postKeysqlnav(Request $request){
        if($request->ajax()){
            if($request->input('type')=='delete'){
                return KeySqlNav::destroy($request->input('navid'));
            }
            if($request->input('id')){
                $nav=KeySqlNav::find($request->input('id'));
            }else{
                $nav=new KeySqlNav;
            }
            $nav->parent_id=$request->input('pid');
            $nav->username=Auth::user()->name;
            $nav->name=$request->input('name');
            $nav->permission=$request->input('permission','');
            $nav->href=$request->input('href','0');
            $nav->desc=$request->input('desc','');
            $nav->fa_icon=$request->input('fa_icon');
            $nav->sql_id=$request->input('sql_id');
            $nav->save();
            return 1;
        }
    }
 
    public function getKeysql(Request $request){
        if($request->input('id')===null){
            $data=KeySql::orderBy('id','desc')->select('id','conn','intotable','cron','sql_desc')->get();
            $columns = array(
                ['data' => 'id', 'title' => 'ID'],
                ['data' => 'sql_desc', 'title' => 'SQL描述'],
                ['data' => 'conn', 'title' => '数据源'],
                ['data' => 'intotable', 'title' => '本地临时表'],
                ['data' => 'cron', 'title' => '周期']
            );
            $res=compact('data','columns');
            return view('keysql::admin.keysql',['res'=>$res]);
        }
        $sql_id=$request->input('id');
        $data=$sql_id?KeySql::find($sql_id):[];
        if(!$data){
            $sql_id=0;
            $data=array(
                'id'=>'',
                'sql_desc'=>'',
                'sqlstr'=>'',
                'conn'=>'',
                'intotable'=>'',
                'cron'=>'',
				'var_json'=>'',
            );
        }
        $dbs=config('database.connections');
        return view('keysql::admin.keysqledit',['sql_id'=>$sql_id,'data'=>$data,'dbs'=>$dbs]);
        
    }

    public function postKeysql(Request $request){
        if($request->ajax()){
            $sql_id=$request->input('sql_id');
            if($sql_id){
                $keysql=KeySql::find($sql_id);
            }else{
                $keysql=new KeySql;
            }
            $keysql->sqlstr=$request->input('sqlstr');
            $keysql->username=Auth::user()->name;
            $keysql->key_id_json=trim($request->input('key_id_json'));
            $keysql->var_json=trim($request->input('var_json'));
            $keysql->echart_json=trim($request->input('echart_json'));
            $keysql->echart_js=trim($request->input('echart_js'));
            $keysql->wx_str=trim($request->input('wx_str'));
            $keysql->intotable=$request->input('intotable');
            $keysql->cron=$request->input('cron');
            $keysql->conn=$request->input('conn');
            $keysql->sql_desc=$request->input('sql_desc');
            $keysql->save();
        }
        
        $sql_id=$keysql->id;
        return $sql_id;
    }

    public function getKeysqltest(Request $request){
        $sql_id=$request->input('id',0);
        $form=[];
        $echarts=[];
        $echartjs=[];
        $desc_table=[];
        
        if($sql_id){
            $keysqldb=KeySql::find($sql_id);
            if($keysqldb){
                $form=$keysqldb->var_json?Helper::my_objectToArray(json_decode($keysqldb->var_json)):[];
                $echarts=$keysqldb->echart_json?Helper::my_objectToArray(json_decode($keysqldb->echart_json)):[];
                $echartjs=$keysqldb->echart_js;
            }
            $desc_table=$keysqldb->getDescTable();
        }
        return view('keysql::admin.keysqltest',compact('sql_id','form','echarts','echartjs','desc_table'));
    }

    public function postKeysqltest(Request $request){

        $keysql=KeySql::find($request->input('sql_id'));
        if($request->input('type')){
            $keysql->tableOperation($request->input('type'));
            return 1;
        }
        $res=$keysql->getTableData($request->input());
        return $res;
    }
 
}