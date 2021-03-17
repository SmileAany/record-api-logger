<?php

namespace Smbear\RecordApiLogger\Services;

use Smbear\RecordApiLogger\Jobs\SaveApiLoggerData;

class RecordApiLoggerService
{
    static public function saveLog(array $params = [])
    {
        if (!empty($params)){
            SaveApiLoggerData::dispatch($params)
                ->onQueue(config('record_api_logger.queue'));
        }
    }
}