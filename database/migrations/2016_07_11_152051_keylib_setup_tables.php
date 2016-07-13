<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class KeyLibSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('zxc__key_lib_dic', function(Blueprint $table)
        {
            $table->integer('key_id')->unsigned()->primary();
            $table->string('key_name')->unique();
            $table->string('key_desc');
        });
        Schema::create('zxc__key_lib', function(Blueprint $table)
        {
            $table->date('logtime');
            $table->tinyInteger('cycle');
            $table->tinyInteger('terminal');
            $table->integer('key_id')->unsigned();
            $table->decimal('key_value',18,4);
            $table->primary(array('logtime','cycle','terminal','key_id'));
            $table->foreign('key_id')->references('key_id')->on('zxc__key_lib_dic')->onUpdate('cascade')->onDelete('restrict');
        });
        Schema::create('zxc__key_lib_realtime', function(Blueprint $table)
        {
            $table->timestamp('logtime');
            $table->tinyInteger('cycle');
            $table->tinyInteger('terminal');
            $table->integer('key_id')->unsigned();
            $table->decimal('key_value',18,4);
            $table->primary(array('logtime','cycle','terminal','key_id'));
            $table->foreign('key_id')->references('key_id')->on('zxc__key_lib_dic')->onUpdate('cascade')->onDelete('restrict');
        });
        Schema::create('zxc__key_lib_alert', function(Blueprint $table)
        {
            $table->datetime('logtime');
            $table->string('user',64);
            $table->string('name',64);
            $table->string('alert_type',64);#online,pay,expend,active
            $table->string('cycle',64);#realtime,daily,weekly,monthly
            $table->decimal('threshold',18,3);
            $table->decimal('data',18,3);
            $table->string('alert_desc',254);
            $table->primary(['logtime','name']);
        });
        Schema::create('zxc__key_lib_sql', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('sqlstr');
            $table->text('key_id_json');
            $table->string('conn',255);
            $table->tinyInteger('cron')->default(0);
            $table->string('sql_desc',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('zxc__key_lib_dic');
        Schema::drop('zxc__key_lib');
        Schema::drop('zxc__key_lib_realtime');
        Schema::drop('zxc__key_lib_alert');
        Schema::drop('zxc__key_lib_sql');
    }
}
