<?php

namespace Zxc\Keysql\Console\Commands;

use Illuminate\Console\Command;

class PyCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'keysql:py {file=umeng.py : 执行文件名称}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run python files in folder "uploads/py".';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo '开始运行python脚本...'.chr(13).chr(10);
        ob_start();
        
        $t1=time();
        $this->python($this->argument('file'));
        $t2=time();
        echo 'python脚本运行完毕，用时'.($t2-$t1).'秒';
        
        $string = ob_get_contents();
        $title='keysql运行python脚本: '.implode(' ',$this->argument()).' 用时'.($t2-$t1).'秒';
        Log::info($title.chr(13).chr(10).$string);
        ob_flush();
        ob_end_clean();
    }

    /*
     * 运行python文件
     */
    public function python($file){
        $prepath=__DIR__.'/../python/';
        $connstr='qxiu_py';
        //$python='/home/didazxc/anaconda3/bin/python3 ';
        $python=' python3 ';
        $program=$python.$prepath.$file."  "
            .config('database.connections.'.$connstr.'.host')." "
            .config('database.connections.'.$connstr.'.username')." '"
            .config('database.connections.'.$connstr.'.password')."' "
            .config('database.connections.'.$connstr.'.port')." "
            .config('database.connections.'.$connstr.'.database'); #注意使用绝对路径
        
        exec ($program,$out,$states);
        echo ($states?'运行失败':'运行成功').chr(13).chr(10);
    }

}
