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
        $acts_query=KeyAct::where('online_time','<=',date('Y-m-d',strtotime('+3 day')))
            ->where('offline_time','>=',date('Y-m-d',strtotime('-3 day')))
            ->orderBy('updated_at','desc')
            ->get();
        $acts_query=$acts_query->filter(function($item){
            if(in_array($item->pattern,['产品功能','版本更新','代码更新'])){
                return time()<strtotime($item->online_time.' +3 day');
            }
            return true;
        });
        $acts=$acts_query->take(10);
        $acts_num=$acts_query->count();
        $view->with(compact('acts','acts_num'));
    }
}