<?php

namespace Smbear\RecordApiLogger;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Support\DeferrableProvider;
use Smbear\RecordApiLogger\Commands\CleanRecordLogger;
use Smbear\RecordApiLogger\Http\Middleware\RecordApi;
use Smbear\RecordApiLogger\Providers\EventServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //注册服务
        $this->app->singleton('record-api-logger',function(){
            return new RecordApiLogger();
        });

        //注册事件的注册服务
        $this->app->register(EventServiceProvider::class);

        //合并配置文件
        $this->mergeConfigFrom(__DIR__.'/../config/config.php','record_api_logger');
    }

    public function boot()
    {
        //绑定中间件，并发布
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(RecordApi::class);

        //发布配置文件
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('record_api_logger.php'),
        ]);

        //迁移数据库文件
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        //注册command
        if ($this->app->runningInConsole()) {
            $this->commands([
                CleanRecordLogger::class,
            ]);
        }
    }
}
