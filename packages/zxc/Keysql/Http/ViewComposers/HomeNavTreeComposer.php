<?php

namespace Zxc\Keysql\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Zxc\Keysql\Models\KeySqlNav;

class HomeNavTreeComposer
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
        #获取导航树
            $home_node=KeySqlNav::where('name','home')->first();
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
            
            $view->with(compact('nav_tree'));
    }
}