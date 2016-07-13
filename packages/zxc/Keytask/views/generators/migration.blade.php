<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class KeyTaskSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{$key_task}}', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('from_user_id')->unsigned();//创建人
			$table->integer('join_user_id')->unsigned();//接口人（指派任务时指定）
            $table->integer('to_user_id')->unsigned();//指派给接受人
            $table->string('name',255);//需求或任务名称
            $table->tinyInteger('pri')->unsigned();//优先级
            $table->decimal('estimate',12,1);//预计时间
            $table->decimal('consumed',12,1);//已消耗时间
            $table->decimal('left',12,1);//预计剩余时间
            $table->dateTime('deadline');//截止时间
            $table->dateTime('starttime');//需求接受时间
            $table->dateTime('endtime');//需求结案时间
            $table->string('status',255)->default('wait');//任务状态:['waitting','doing','done','cancelling','cancelled','success']
            $table->text('desc');//需求或任务的描述
            $table->text('result');//需求或任务的反馈结果
            $table->timestamps();
        });
        Schema::create('{{$key_task_hour}}', function(Blueprint $table)
        {
            $table->increments('id');
            $table->date('logtime');//可补录，工作日期
            $table->integer('task_id')->unsigned();//外键
            $table->integer('user_id')->unsigned();//操作用户
            $table->string('operation',255);//操作内容：'hour-set'，'waitting','doing','done','cancelling','cancelled','success'
            $table->decimal('consumed',12,1);//消耗工时
            $table->decimal('left',12,1);//预计剩余
            $table->text('desc');//工作内容描述
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('{{$key_task}}')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('{{ $key_task_hour }}');
        Schema::drop('{{ $key_task }}');
    }
}
