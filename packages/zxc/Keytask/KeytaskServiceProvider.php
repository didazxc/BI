<?php

namespace Zxc\Keytask;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Zxc\Keytask\Console\Commands\MigrationCommand;
use Zxc\Keytask\Console\Commands\PyCommand;
use Illuminate\Contracts\Auth\Access\Authorizable;

class KeytaskServiceProvider extends ServiceProvider
{
    public function boot(){
        //指定视图位置
        $this->loadViewsFrom(realpath(__DIR__.'/views'),'keytask');
        //配置路由
        $this->app->router->group(['namespace'=>'Zxc\Keytask\Http\Controllers','middleware' => ['web','auth']],function(Router $router){
            require __DIR__.'/Http/routes.php';
        });
        //配置共享视图变量
        include __DIR__.'/Http/ViewComposers/viewComposers.php';
        view()->composer(
            ['keytask::adminlteunits.nav-tasks'],
            'Zxc\Keytask\Http\ViewComposers\NavTasksComposer');
        //绑定自定义命令
        $this->commands('command.keytask.migration');
    }

    public function register(){
        //绑定keysql模块
        $this->app->bind('keytask',function($app){
            return new Keytask($app);
        });
        //绑定自定义命令
        $this->app->singleton('command.keytask.migration', function ($app) {
            return new MigrationCommand();
        });
    }
}