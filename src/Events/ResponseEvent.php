<?php

namespace Smbear\RecordApiLogger\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class ResponseEvent extends Event
{
    public $request;

    public $response;

    public function __construct(Request $request,$response)
    {
        $this->request  = $request;

        $this->response = $response;
    }
}