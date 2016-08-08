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
                #判断是否是admin的目录
                $admin_node=KeySqlNav::where('name','admin')->first();
                if($thisnav->isDescendantOf($admin_node)){
                    $home_node=$admin_node;
                }else{
                    $home_node=KeySqlNav::where('name','home')->first();
                }
            }else{
                #非数据库路径注册处（现：菜单查询）
                $path=new Collection([
                    new KeySqlNav(['name'=>'home']),
                    new KeySqlNav(['name'=>'查询','desc'=>'菜单查询','fa_icon'=>'fa-search'])
                ]);
                $home_node=KeySqlNav::where('name','home')->first();
            }
        #获取导航树
            $nav_collection=KeySqlNav::whereDescendantOf($home_node)->defaultOrder()->get();
            if(!$this->auth->user()->can(config('keysql.permission_admin'))){
                $user=$this->auth->user();
                //去掉无权限的叶子节点
                $nav_collection=$nav_collection->filter(function($item)use($user){
                    if($item->is_leaf()){
                        if(!$user->can($item->permission)){
                            return $user->can($item->parentnav()->permission);
                        }
                    }
                    return true;
                });
                //去掉无叶子的节点
                $nav_collection=$nav_collection->filter(function($item)use($nav_collection){
                    if(!$item->is_leaf()){
                        return $nav_collection->filter(function($i)use($item){
                                return $i->_lft>$item->_lft && $i->_rgt<$item->_rgt;
                            })->count();
                    }
                    return true;
                });
            }
            $nav_tree=$nav_collection->toTree();
        
            $view->with(compact('nav_tree','path'));
    }
}