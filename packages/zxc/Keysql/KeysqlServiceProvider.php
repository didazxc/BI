<?php

namespace Zxc\Keysql;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Zxc\Keysql\Console\Commands\MigrationCommand;
use Zxc\Keysql\Console\Commands\UpdateKeySql;
use Zxc\Keysql\Console\Commands\PyCommand;
use Zxc\Keysql\Console\Commands\RCommand;

class KeysqlServiceProvider extends ServiceProvider
{
    //public发布目录
    public static $public_path='packages/zxc';

    public function boot(){
        //指定视图位置
        $this->loadViewsFrom(realpath(__DIR__.'/views'),'keysql');
        //配置路由
        $this->app->router->group(['namespace'=>'Zxc\Keysql\Http\Controllers','middleware' => ['web','auth']],function(Router $router){
            require __DIR__.'/Http/routes.php';
        });
        //发布config文件
        $this->publishes([
            realpath(__DIR__.'/../config/keysql.php') => config_path('keysql.php'),
        ]);
        //发布public文件
        $this->publishes([
            __DIR__.'/../public' => public_path(KeysqlServiceprovider::$public_path),
        ], 'public');
        //配置共享视图变量
        include __DIR__.'/Http/ViewComposers/viewComposers.php';
    }

    public function register(){
        //config文件发布后的路径
        config(['config/keysql.php']);
        //绑定自定义命令
        $this->commands('Zxc\Keysql\Console\Commands\MigrationCommand');
        $this->commands('Zxc\Keysql\Console\Commands\UpdateKeySql');
        $this->commands('Zxc\Keysql\Console\Commands\PyCommand');
        $this->commands('Zxc\Keysql\Console\Commands\RCommand');
    }
}