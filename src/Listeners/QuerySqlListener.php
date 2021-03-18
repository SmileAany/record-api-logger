<?php

namespace Smbear\RecordApiLogger\Listeners;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Events\QueryExecuted;
use Smbear\RecordApiLogger\Events\RequestEvent;

class QuerySqlListener
{
    public function handle(RequestEvent $event)
    {
        $uniqueId = $event->request->headers->get('R-Unique-Id');

        DB::listen(function (QueryExecuted $query) use ($uniqueId) {
            $bindings = $query->connection->prepareBindings($query->bindings);

            foreach ($bindings as $key => $binding){
                if ($binding instanceof \DateTime) {
                    $bindings[$key] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    $bindings[$key]= $binding;
                }
            }

            $sql = str_replace(array('%', '?'), array('%%', '%s'), $query->sql);
            $sql = vsprintf($sql,$bindings);

            $data = [
                'database'  => $query->connection->getDatabaseName(),
                'time'      => ($query->time) / 1000,
                'sql'       => $sql,
            ];

            $cache = Cache::get($uniqueId) ?? [];
            $cache['query'][] = $data;

            Cache::put($uniqueId,$cache,config('record_api_logger.cache_time'));
        });
    }
}