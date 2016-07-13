<?php
namespace Zxc\Keysql\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Zxc\Keysql\Models\KeySqlNav;
use Zxc\Keysql\Models\KeySql;
use Zxc\Keysql\Models\Helper;
use Auth;
use Route;
use Redirect;

class HomeController extends BaseController
{
    public function __construct(){
        view()->composer(
            ['keysql::layouts.sidebar','keysql::layouts.breadcrumb'],
            'Zxc\Keysql\Http\ViewComposers\HomeNavComposer');
    }

    public function index(){
        return view('keysql::home.home',['sysname'=>config('keysql.sysname')]);
    }

    public function searchnav(Request $request){
        $q=$request->input('q');
        $home_node=KeySqlNav::where('name','home')->first();
        $navs=KeysqlNav::whereDescendantOf($home_node);
        if($q){
            $navs=$navs->where('name','like','%'.$q.'%');
        }
        $navs=$navs->get();
        return view('keysql::home.navlist',compact('navs'));
    }
    
    public function postKeysql(Request $request){
        $keysql=KeySql::find($request->input('sql_id'));
        $res=$keysql->getTableData($request->input());
        return $res;
    }

    public function getKeysql(Request $request){
        
        $nav_id=$request->route('nav_id');
        $sql_id=KeySqlNav::find($nav_id)->sql_id;
        
        $var_json=[];
        $echart_json=[];
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
        return view('keysql::home.keysql',compact('sql_id','form','echarts','echartjs','desc_table'));
    }

    public function getwx(Request $request)
    {

        $hour=$request->has('H')?$request->input('H'):'09';
        $min=$request->has('i')?$request->input('i'):'30';


        if(date('H')==$hour && intval(date('i'))<$min){
            $keysql=KeySql::find($request->route('sql_id'));
            $res['str']=$keysql->getWxStr($request->input());
        }else{
            $res['str']='';
        }
        return view('keysql::home.wx',['res'=>(json_encode($res))]);
    }

    public function getexcel(Request $request)
    {
        return 0;
    }
    
}
