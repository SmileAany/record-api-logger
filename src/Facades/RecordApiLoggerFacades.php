<?php

namespace Smbear\RecordApiLogger\Facades;

use Illuminate\Support\Facades\Facade;

class RecordApiLoggerFacades extends Facade
{
    protected static function getFacadeAccessor():string
    {
        return 'record-api-logger';
    }
}