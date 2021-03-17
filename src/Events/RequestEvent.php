<?php

namespace Smbear\RecordApiLogger\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class RequestEvent extends Event
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request =  $request;
    }
}
