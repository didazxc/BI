<?php

namespace Zxc\Keylib;

use Illuminate\Support\ServiceProvider;

class KeylibServiceProvider extends ServiceProvider
{

    public function boot(){
        
    }

    public function register(){
        //指定视图位置
        $this->loadViewsFrom(realpath(__DIR__.'/views'),'keylib');
        //绑定自定义命令
        $this->commands('Zxc\Keylib\Console\Commands\MigrationCommand');
        $this->commands('Zxc\Keylib\Console\Commands\UpdateKeyLib');
    }
}