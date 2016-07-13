<?php

namespace Zxc\Keysql\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Zxc\Keysql\Models\KeySqlNav;

class HomeNavComposer
{
    protected $auth;
    protected $request;

    public function __construct(Guard $auth,Request $request)
    {
        $this->auth = $auth;
        $this->request = $request;
    }

    /**
     * 绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        //加载目录
            $home_node=KeySqlNav::where('name','home')->first();
            #获取导航树
            $nav_collection=KeySqlNav::whereDescendantOf($home_node)->defaultOrder()->get();
            foreach($nav_collection as $k=>$nav){
                if(!$this->auth->user()->can(config('keysql.permission_prefix').$nav->id)){
                    $nav_collection->forget($k);
                }
            }
            $nav_tree=$nav_collection->toTree();
            #获取当前nav位置
            $nav_id=$this->request->route('nav_id');
            if($nav_id){
                $thisnav=KeySqlNav::find($nav_id);
            }else{
                $href='/'.$this->request->path();
                $thisnav=KeySqlNav::where('href',$href)->first();
            }
            #获取路径
            if($thisnav){
                $path=$thisnav->ancestors()->where('id','>','1')->get();
                $path->push($thisnav);
            }else{#非数据库路径注册处（现：菜单查询）
                $path=new Collection([
                    new KeySqlNav(['name'=>'home']),
                    new KeySqlNav(['name'=>'查询','desc'=>'菜单查询','fa_icon'=>'fa-search'])
                ]);
            }
            $view->with(compact('nav_tree','path'));
    }
}