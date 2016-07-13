<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class KeyActSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{$key_act}}', function(Blueprint $table)
        {			
			$table->bigIncrements('id');
            $table->integer('userid')->unsigned();//创建者
            $table->string('pattern',255);//活动名称
            $table->string('act_name',255);//类型
            $table->string('goal',3000);//目标json
            $table->dateTime('online_time');//起始时间
            $table->dateTime('offline_time');//结束时间
            $table->text('online_intro');//上线说明
            $table->text('offline_intro');//结案汇报
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
        Schema::drop('{{ $key_act }}');
    }
}
