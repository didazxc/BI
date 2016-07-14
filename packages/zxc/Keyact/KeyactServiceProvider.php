<?php

namespace Zxc\Keyact;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Zxc\Keyact\Console\Commands\MigrationCommand;
use Illuminate\Contracts\Auth\Access\Authorizable;

class KeyactServiceProvider extends ServiceProvider
{
    public function boot(){
        //指定视图位置
        $this->loadViewsFrom(realpath(__DIR__.'/views'),'keyact');
        //配置路由
        $this->app->router->group(['namespace'=>'Zxc\Keyact\Http\Controllers','middleware' => ['web','auth']],function(Router $router){
            require __DIR__.'/Http/routes.php';
        });
        //发布config文件
        $this->publishes([
            realpath(__DIR__.'/../config/keyact.php') => config_path('keyact.php'),
        ]);
        //配置共享视图变量
        view()->composer(
            ['keyact::adminlteunits.nav-acts'],
            'Zxc\Keyact\Http\ViewComposers\NavActsComposer');
        //绑定自定义命令
        //绑定自定义命令
        $this->commands('command.keyact.migration');
    }

    public function register(){
        //绑定keyact模块
        $this->app->bind('keyact',function($app){
            return new Keyact($app);
        });
        //config文件发布后的路径
        config(['config/keyact.php']);
        //绑定自定义命令
        $this->app->singleton('command.keyact.migration', function ($app) {
            return new MigrationCommand();
        });
    }
}