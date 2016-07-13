<?php

namespace Zxc\Keylib\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Zxc\Keylib\Models\KeyLibAlert;

class UpdateKeyLibAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keylib:alert {files? : 运行文件}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update data from R.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo '更新KeyLibAlert数据...'.chr(13).chr(10);
        $t1=time();
        $files=json_decode($this->argument('files'));
        $this->runr($files);
        $t2=time();
        echo 'KeyLibAlert数据更新完毕，用时'.($t2-$t1).'秒';
    }

    public function runr($files=[]){
        $dir=__DIR__.'/../R/';
        if($files==[]){
            $files=$this->getfiles($dir);
        }
        var_dump($files);
        foreach($files as $file){
            try{
                if(pathinfo($file, PATHINFO_EXTENSION)=='R'){
                    $out=$this->R($dir.$file);
                }elseif(pathinfo($file, PATHINFO_EXTENSION)=='py'){
                    $out=$this->python($dir.$file);
                }else{
                    $out=[];
                }
                var_dump($out);
                $this->intoTable($out);
            }catch(Exception $e){
                var_dump($file);
                var_dump($out);
                echo $e->getMessage().chr(10).chr(13);
                echo '失败！'.chr(10).chr(13);
            }
        }
    }

    /*
     * 运行python文件
     */
    public function python($file){
        
        $connstr='qxiu_py';
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
    public function R($file){
        $connstr='qxiu_py';
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
    
    public function intoTable($out){
        if($out){
            $keyAlert=new KeyLibAlert();
            $keyAlert->logtime=$out[0];
            $keyAlert->name=$out[1];
            $keyAlert->user=$out[2];
            $keyAlert->alert_type=$out[3];
            $keyAlert->cycle=$out[4];
            $keyAlert->threshold=$out[5];
            $keyAlert->data=$out[6];
            $keyAlert->alert_desc=$out[7];
            $keyAlert->save();
        }
    }
    
    public function getfiles($dir){
        $dirlist=[];
        if(is_dir($dir)){
            if($dh=opendir($dir)){
                 while (($file = readdir($dh)) !== false){
                    if(!is_dir($dir."/".$file) && $file!='.' && $file!='..'){
                        $dirlist[]=$file;
                    }
                 }
                 closedir($dh);
            }
        }
        return $dirlist;
    }
    
}
