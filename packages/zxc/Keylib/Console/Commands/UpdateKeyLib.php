<?php

namespace Zxc\Keylib\Console\Commands;

use Illuminate\Console\Command;
use Zxc\Keylib\Models\KeyLibSql;

class UpdateKeyLib extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keylib:update {cycle=daily : 运行周期} {startdate? : 起始日期} {enddate? : 结束日期} {id_array? : ID数组}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update data from key_lib_sql.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        echo '更新KeyLib数据...'.chr(13).chr(10);
        $t1=time();
        $id_array=json_decode($this->argument('id_array'));
        KeyLibSql::updateKeyLib($this->argument('cycle'),$this->argument('startdate'),$this->argument('enddate'),$id_array,true);
        $t2=time();
        echo 'KeyLib数据更新完毕，用时'.($t2-$t1).'秒';
    }


}
