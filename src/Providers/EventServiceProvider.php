<?php

namespace Smbear\RecordApiLogger\Providers;

use Smbear\RecordApiLogger\Events\ResponseEvent;
use Smbear\RecordApiLogger\Events\RequestEvent;
use Smbear\RecordApiLogger\Events\QuerySqlEvent;
use Smbear\RecordApiLogger\Listeners\QuerySqlListener;
use Smbear\RecordApiLogger\Listeners\RequestListener;
use Smbear\RecordApiLogger\Listeners\ResponseListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    //绑定监听器
    protected $listen = [
        RequestEvent::class  =>[
            RequestListener::class
        ],
        ResponseEvent::class =>[
            ResponseListener::class
        ],
        QuerySqlEvent::class =>[
            QuerySqlListener::class
        ]
    ];

    public function boot()
    {
        return parent::boot();
    }
}