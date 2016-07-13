<?php

namespace Zxc\Keylib;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Zxc\Keylib\Console\Commands\MigrationCommand;
use Zxc\Keylib\Console\Commands\UpdateKeyLib;
use Zxc\Keylib\Console\Commands\UpdateKeyLibAlert;


class KeylibServiceProvider extends ServiceProvider
{

    public function boot(){
        //绑定自定义命令
        $this->commands('command.keylib.migration');
        $this->commands('command.keylib.update');
        $this->commands('command.keylib.alert');
        //配置共享视图变量
        view()->composer(
            ['keylib::adminlteunits.nav-alerts'],
            'Zxc\Keylib\Http\ViewComposers\NavAlertsComposer');
    }

    public function register(){
        //指定视图位置
        $this->loadViewsFrom(realpath(__DIR__.'/views'),'keylib');
        //绑定keysql模块
        $this->app->bind('keylib',function($app){
            return new Keylib($app);
        });
        //绑定自定义命令
        $this->app->singleton('command.keylib.migration', function ($app) {
            return new MigrationCommand();
        });
        $this->app->singleton('command.keylib.update', function ($app) {
            return new UpdateKeyLib();
        });
        $this->app->singleton('command.keylib.alert', function ($app) {
            return new UpdateKeyLibAlert();
        });
    }
}