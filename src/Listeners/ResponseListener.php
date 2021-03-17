<?php

namespace Smbear\RecordApiLogger\Listeners;

use Illuminate\Support\Facades\Cache;
use Smbear\RecordApiLogger\Services\RecordApiLoggerService;
use Smbear\RecordApiLogger\Events\ResponseEvent;

class ResponseListener
{
    public function handle(ResponseEvent $event)
    {
        $request  = $event->request;
        $response = $event->response;

        $endTime = microtime(true);

        $data = [
            'ip'       => $request->ip(),
            'method'   => $request->method(),
            'path'     => $request->path(),
            'params'   => $request->all() ? json_encode($request->all()) : '',
            'server'   => $request->server('SERVER_NAME'),
            'response' => $response->getContent(),
            'time'     => sprintf('%.2f',($endTime - LARAVEL_START) * 1000)
        ];

        $uniqueId = request()->headers->get('R-Unique-Id');
        $cache = Cache::get($uniqueId) ?: [];
        $cache['request'] = $data;

        Cache::forget($uniqueId);

        RecordApiLoggerService::saveLog($cache);
    }
}