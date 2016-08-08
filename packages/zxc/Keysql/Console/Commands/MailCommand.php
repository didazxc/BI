<?php

namespace Zxc\Keysql\Console\Commands;

use Illuminate\Console\Command;
use Mockery\Exception;
use DB;
use Log;
use Mail;

class MailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keysql:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto send mail';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $this->report();
        }catch(Exception $e){
            Log::warning('邮件发送失败');
        }
    }

    public function report(){
        $sql=<<<SQL
SELECT  [日期]
      ,[当天总注册人数]
      ,[PC注册]
      ,[移动注册]
      ,[安卓注册]
      ,[手Q新增]
  FROM [QIQI_Stats].[dbo].[t_mail_tencent_report]
SQL;
        $res=DB::connection('qq_stats_sqlsrv')->select($sql);

        Mail::send('keysql::emails.mail_table', ['title'=>'齐齐数据日报','data'=>$res], function($message)
        {
            $message->to(['dongmei@17guagua.com','wangxue@17guagua.com','zhangxiaochuan@17guagua.com','v_minwen@tencent.com','chloezhu@tencent.com','rainzywang@tencent.com','shuweizhang@tencent.com'])->subject('齐齐数据，请查收！');
            //$message->to(['zhangxiaochuan@17guagua.com'])->subject('齐齐数据，请查收！');
        });
    }

}

