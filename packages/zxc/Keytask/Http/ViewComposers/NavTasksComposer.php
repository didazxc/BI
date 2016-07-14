<?php

namespace Zxc\Keytask\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use Zxc\Keytask\KeyTask;

class NavTasksComposer
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
        $tasks_query=KeyTask::where('endtime','>=',date('Y-m-d',strtotime('-3 days')))->OrWhere('status','doing');
        $tasks=$tasks_query->orderBy('updated_at','desc')->limit(10)->get();
        $tasks_num=$tasks_query->count('*');
        $view->with(compact('tasks','tasks_num'));
    }
}