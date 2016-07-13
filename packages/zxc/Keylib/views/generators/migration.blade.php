<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class KeyLibSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{$keylib_dic_table}}', function(Blueprint $table)
        {
            $table->integer('key_id')->unsigned()->primary();
            $table->string('key_name')->unique();
            $table->string('key_desc');
        });
        Schema::create('{{$keylib_table}}', function(Blueprint $table)
        {
            $table->date('logtime');
            $table->tinyInteger('cycle');
            $table->tinyInteger('terminal');
            $table->integer('key_id')->unsigned();
            $table->decimal('key_value',18,4);
            $table->primary(array('logtime','cycle','terminal','key_id'));
            $table->foreign('key_id')->references('key_id')->on('{{$keylib_dic_table}}')->onUpdate('cascade')->onDelete('restrict');
        });
        Schema::create('{{$keylib_realtime_table}}', function(Blueprint $table)
        {
            $table->timestamp('logtime');
            $table->tinyInteger('cycle');
            $table->tinyInteger('terminal');
            $table->integer('key_id')->unsigned();
            $table->decimal('key_value',18,4);
            $table->primary(array('logtime','cycle','terminal','key_id'));
            $table->foreign('key_id')->references('key_id')->on('{{$keylib_dic_table}}')->onUpdate('cascade')->onDelete('restrict');
        });
        Schema::create('{{$keylib_alert_table}}', function(Blueprint $table)
        {
            $table->datetime('logtime');
            $table->string('name',64);
            $table->string('user',64);
            $table->tinyInteger('pro')->defalut(0);#严重程度
            $table->string('alert_keys',1024);
            $table->text('alert_desc');
            $table->primary(['logtime','name']);
        });
        Schema::create('{{$keylib_sql_table}}', function(Blueprint $table)
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
     * @return void
     */
    public function down()
    {
        Schema::drop('{{ $keylib_dic_table }}');
        Schema::drop('{{ $keylib_table }}');
        Schema::drop('{{ $keylib_realtime_table }}');
        Schema::drop('{{ $keylib_alert_table }}');
        Schema::drop('{{ $keylib_sql_table }}');
    }
}
