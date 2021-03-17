<?php

namespace Smbear\RecordApiLogger\Events;

use Illuminate\Support\Facades\Event;

class QuerySqlEvent extends Event
{
    public $uniqueId;

    public function __construct(string $uniqueId)
    {
        $this->uniqueId =  $uniqueId;
    }
}