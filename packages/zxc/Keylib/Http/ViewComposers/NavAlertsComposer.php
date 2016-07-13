<?php

namespace Zxc\Keylib\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use Zxc\Keylib\Models\KeyLibAlert;

class NavAlertsComposer
{
    public function __construct()
    {
        
    }

    /**
     * 绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $alerts_query=KeyLibAlert::where('logtime','>=',date('Y-m-d',strtotime('-7 days')));
        $alerts=$alerts_query->orderBy('pro','desc')->limit(10)->get();
        $alerts_num=$alerts_query->count('*');
        $view->with(compact('alerts','alerts_num'));
    }
}