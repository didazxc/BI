<?php

namespace Zxc\Keysql\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Zxc\Keysql\Models\KeySqlNav;

class AdminNavComposer
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
            $admin_node=KeySqlNav::where('name','admin')->first();
            $nav_tree=KeySqlNav::whereDescendantOf($admin_node)->defaultOrder()->get()->toTree();
            
            $href='/'.$this->request->path();
            $thisnav=KeySqlNav::where('href',$href)->first();
            $path=$thisnav->ancestors()->where('id','>','1')->get();
            $path->push($thisnav);
            $view->with(compact('nav_tree','path'));
    }
}