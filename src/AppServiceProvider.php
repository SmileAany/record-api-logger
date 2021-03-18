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
        //绑定api中间件，并发布
        $kernel = $this->app->make(Kernel::class);
        $kernel->appendMiddlewareToGroup('api',RecordApi::class);

        //迁移数据库文件
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        if ($this->app->runningInConsole()) {

            //发布配置文件
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('record_api_logger.php'),
            ]);

            //注册command
            $this->commands([
                CleanRecordLogger::class,
            ]);

            //发布数据库文件
            if (!class_exists('CreateRecordApiTable')) {
                $this->publishes([
                    __DIR__ . '/../migrations/create_record_api_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_record_api_table.php'),
                ], 'migrations');

                $this->publishes([
                    __DIR__ . '/../migrations/create_record_query_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_record_query_table.php'),
                ], 'migrations');
            }
        }
    }
}
