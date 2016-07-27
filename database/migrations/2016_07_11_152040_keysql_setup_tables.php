<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Illuminate\Support\Facades\DB;
class KeySqlSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('zxc__key_sql_nav', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('username',255)->default('');
            $table->string('name')->unique();
            $table->string('permission',255)->default('');
            $table->string('desc');
            $table->string('fa_icon')->default('fa-star');
            $table->integer('sql_id')->unsigned()->default(0);
            $table->string('href')->default('0');
            Nestedset::columns($table);
            $table->timestamps();
        });
        
        Schema::create('zxc__key_sql', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('username',255)->default('');
            $table->text('sqlstr');
            $table->text('key_id_json');
            $table->string('var_json',1023);
            $table->text('echart_json');
            $table->text('echart_js');
            $table->text('wx_str');
            $table->string('conn',255);
            $table->string('intotable',50)->default('');
            $table->tinyInteger('cron')->default(0);
            $table->string('sql_desc',255);
            $table->timestamps();
        });
        Schema::create('zxc__key_sql_access_log', function(Blueprint $table)
        {
            $table->increments('id');
            $table->datetime('logtime');
            $table->string('username',255)->default('');
            $table->integer('userid')->unsigned()->default(0);
            $table->string('url',1023);
            $table->string('input',1023);
            $table->string('method');
            $table->integer('navid')->unsigned()->default(0);
            $table->string('navname')->default('');
            $table->integer('sqlid')->unsigned()->default(0);
        });
        DB::insert(
<<<SQL
        INSERT INTO zxc__key_sql_nav 
            (`id`,`name`,`desc`,`fa_icon`,`sql_id`,`href`,`_lft`,`_rgt`,`parent_id`) 
        VALUES
            (1, 'root', '网站根目录', 'fa-star', 0, '0', 1, 20, NULL),
            (2, 'admin', '后台根目录', 'fa-star', 0, '0', 2, 15, 1),
            (3, '返回前台', '后台返回前台首页', 'fa-home', 0, '/', 3, 4, 2),
            (4, 'KEYSQL管理', '后台KEYSQL管理', 'fa-coffee', 0, '0', 5, 12, 2),
            (5, '菜单编辑', '后台KEYSQL导航管理', 'fa-list', 0, '/keysql/admin/keysqlnav', 6, 7, 4),
            (6, 'SQL录入', '后台KEYSQL录入管理', 'fa-database', 0, '/keysql/admin/keysql', 8, 9, 4),
            (7, '调试页', '测试SQL语句与页面布局', 'fa-photo', 0, '/keysql/admin/keysqltest', 10, 11, 4),
            (8, '模型管理', '', 'fa-cubes', 0, '/admin', 13, 14, 2),
            (9, 'home', '前台根目录', 'fa-star', 0, '/keysql', 16, 19, 1),
            (10, 'KEYSQL后台', 'KEYSQL后台', 'fa-gears', 0, '/keysql/admin', 17, 18, 9)
            ;
SQL
        );
        DB::insert(
<<<SQL
        INSERT INTO permissions 
            (`name`,`display_name`,`description`) 
        VALUES
            ('keysql/admin', 'keysql管理权限', 'keysql管理后台')
            ;
SQL
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('zxc__key_sql_nav');
        Schema::drop('zxc__key_sql');
    }
}
