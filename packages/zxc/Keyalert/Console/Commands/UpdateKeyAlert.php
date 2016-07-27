<?php

namespace Zxc\Keyalert\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Zxc\Keyalert\Models\KeyAlert;
use Zxc\Keyalert\Models\KeyAlertScripts;
use Log;

class UpdateKeyAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keyalert:update {cycle=daily : 运行周期} {scripts_id? : 运行文件}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update data from R/python.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo '更新KeyAlert数据...'.chr(13).chr(10);
        ob_start();
        
        $t1=time();
        $scripts_id=json_decode($this->argument('scripts_id'));
        $this->runr($this->argument('cycle'),$scripts_id);
        $t2=time();
        echo 'KeyAlert数据更新完毕，用时'.($t2-$t1).'秒';

        $string = ob_get_contents();
        $title='更新KeyAlert数据: '.implode(' ',$this->argument()).' 用时'.($t2-$t1).'秒';
        $logstr=$title.chr(13).chr(10).$string;
        if(strpos($string,'失败')){
            Log::warning($logstr);
        }elseif($this->argument('cycle')!='realtime'){
            Log::info($logstr);
        }
        
        ob_flush();
        ob_end_clean();
    }

    public function runr($cycle,$scripts_id=[])
    {
        $scripts=$this->getScripts($cycle,$scripts_id);
        foreach($scripts as $script){
            echo '运行 ID='.$script->id;
            try{
                $dir=storage_path('app/keyalert/');
                $file=$script->file;
                if(pathinfo($file, PATHINFO_EXTENSION)=='R'){
                    $out=$this->R($dir.$file);
                }elseif(pathinfo($file, PATHINFO_EXTENSION)=='py'){
                    $out=$this->python($dir.$file);
                }else{
                    continue;
                }
                var_dump($out);
                if($out && $out[0]!='NULL' && $out[0]!='0' && $out[0]!='' && $out[1]!=''){
                    $keyAlert=new KeyAlert();
                    $keyAlert->logtime=date('Y-m-d H:i:s');
                    $keyAlert->script_id=$script->id;
                    switch($cycle){
                        case 'weekly':
                            $cron=2;
                            break;
                        case 'monthly':
                            $cron=4;
                            break;
                        case 'realtime':
                            $cron=8;
                            break;
                        case 'hourly':
                            $cron=16;
                            break;
                        case 'daily':
                        default:
                            $cron=1;
                    }
                    $keyAlert->cron=$cron;
                    $keyAlert->pro=$out[0];
                    $keyAlert->alert_desc=$out[1];
                    $keyAlert->save();
                }
            }catch(Exception $e){
                var_dump($file);
                var_dump($out);
                echo $e->getMessage().chr(10).chr(13);
                echo '失败！'.chr(10).chr(13);
            }
        }
    }
    
    public function getScripts($cycle='daily',$scripts_id=[])
    {   
        if($scripts_id==[])
        {
            $dir=storage_path('app/keyalert');
            switch($cycle){
                case 'weekly':
                    $crons=[2,3,6,7];
                    break;
                case 'monthly':
                    $crons=[4,5,6,7];
                    break;
                case 'realtime':
                    $crons=[8];
                    break;
                case 'hourly':
                    $crons=[16];
                    break;
                case 'daily':
                default:
                    $crons=[1,3,5,7];
            }
            return KeyAlertScripts::whereIn('cron',$crons)->get();
        }else{
            return KeyAlertScripts::whereIn('id',$scripts_id)->get();
        }
    }
    
    /*
     * 运行python文件
     */
    public function python($file)
    {
        
        $connstr='mysql';
        //$python='/home/didazxc/anaconda3/bin/python3 ';
        $python='python3 ';
        $program=$python.$file."  "
            .config('database.connections.'.$connstr.'.host')." "
            .config('database.connections.'.$connstr.'.username')." '"
            .config('database.connections.'.$connstr.'.password')."' "
            .config('database.connections.'.$connstr.'.port')." "
            .config('database.connections.'.$connstr.'.database'); #注意使用绝对路径
        
        exec ($program,$out,$states);
        echo ($states?'运行失败':'运行成功').chr(13).chr(10);
        return $out;
    }
    /*
     * 运行R文件
     */
    public function R($file)
    {
        $connstr='mysql';
        $Rscript='Rscript ';
        $program=$Rscript.$file."  "
            .config('database.connections.'.$connstr.'.host')." "
            .config('database.connections.'.$connstr.'.username')." '"
            .config('database.connections.'.$connstr.'.password')."' "
            .config('database.connections.'.$connstr.'.port')." "
            .config('database.connections.'.$connstr.'.database'); #注意使用绝对路径
        
        exec ($program,$out,$states);
        echo ($states?'运行失败':'运行成功').chr(13).chr(10);
        if($out){
            foreach($out as $k=>$v){
                $out[$k]=preg_replace('/(^\[\d+\] "?)|("$)/','',$v);
            }
        }
        
        return $out;
    }
    
    
}
