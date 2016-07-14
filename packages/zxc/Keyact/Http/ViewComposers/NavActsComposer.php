<?php

namespace Zxc\Keyact\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use Zxc\Keyact\KeyAct;

class NavActsComposer
{
    public function __construct()
    {}

    /**
     * 绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $acts_query=KeyAct::where('online_time','<=',date('Y-m-d'))->Where('offline_time','>=',date('Y-m-d'));
        $acts=$acts_query->orderBy('updated_at','desc')->limit(10)->get();
        $acts_num=$acts_query->count('*');
        $view->with(compact('acts','acts_num'));
    }
}