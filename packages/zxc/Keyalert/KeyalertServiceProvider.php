<?php

namespace Zxc\Keyalert;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class KeyalertServiceProvider extends ServiceProvider
{

    public function boot(){
        //配置共享视图变量
        view()->composer(
            ['keyalert::adminlteunits.nav-alerts'],
            'Zxc\Keyalert\Http\ViewComposers\NavAlertsComposer');
        //配置路由
        $this->app->router->group(['namespace'=>'Zxc\Keyalert\Http\Controllers','middleware' => ['web','auth']],function(Router $router){
            require __DIR__.'/Http/routes.php';
        });
    }

    public function register(){
        //指定视图位置
        $this->loadViewsFrom(realpath(__DIR__.'/views'),'keyalert');
        //绑定自定义命令
        $this->commands('Zxc\Keyalert\Console\Commands\MigrationCommand');
        $this->commands('Zxc\Keyalert\Console\Commands\UpdateKeyAlert');
    }
}