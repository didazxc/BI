<?php

namespace Zxc\Keysql\Console\Commands;

use Illuminate\Console\Command;

class RCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'keysql:r {file=test.r : 执行文件名称}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run R files in folder "uploads/py".';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo '开始运行R脚本...'.chr(13).chr(10);
        $t1=time();
        $this->R($this->argument('file'));
        $t2=time();
        echo 'R脚本运行完毕，用时'.($t2-$t1).'秒';
    }

    /*
     * 运行R文件
     */
    public function R($file){
        $prepath=__DIR__.'/../R/';
        $connstr='qxiu_py';
        $Rscript='Rscript ';
        $program=$Rscript.$prepath.$file."  "
            .config('database.connections.'.$connstr.'.host')." "
            .config('database.connections.'.$connstr.'.username')." '"
            .config('database.connections.'.$connstr.'.password')."' "
            .config('database.connections.'.$connstr.'.port')." "
            .config('database.connections.'.$connstr.'.database'); #注意使用绝对路径
        
        exec ($program,$out,$states);
        echo ($states?'运行失败':'运行成功').chr(13).chr(10);
    }

}
