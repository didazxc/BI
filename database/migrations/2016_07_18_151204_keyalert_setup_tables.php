<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class KeyAlertSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('zxc__key_alert_scripts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('username');
            $table->string('name')->unique();
            $table->string('faicon',64)->defalut('warning');#fa图标
            $table->tinyInteger('cron')->default(0);#1日2周4月8实时
            $table->string('script_desc',255);
            $table->string('file',511);#脚本路径
            $table->timestamps();
        });
        Schema::create('zxc__key_alert', function(Blueprint $table)
        {
            $table->datetime('logtime');
            $table->integer('script_id')->unsigned();
            $table->tinyInteger('cron')->default(0);#1日2周4月8实时
            $table->tinyInteger('pro')->defalut(0);#严重程度1普通（不做通知）,2严重（微信通知）,3紧急（微信与邮件通知）
            $table->text('alert_desc');
            $table->primary(['logtime','script_id','cron']);
            $table->foreign('script_id')->references('id')->on('{{$keyalert_scripts_table}}')->onUpdate('cascade')->onDelete('restrict');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('zxc__key_alert');
        Schema::drop('zxc__key_alert_scripts');
    }
}
