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
            foreach($nav_collection as $k=>$nav){
                if($this->auth->user()->can(config('keysql.permission_admin'))){
                    continue;
                }
                if(!$this->auth->user()->can($nav->permission)){
                    $nav_collection->forget($k);
                }
            }
            $nav_tree=$nav_collection->toTree();
            
            $view->with(compact('nav_tree'));
    }
}