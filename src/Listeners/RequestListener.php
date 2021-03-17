<?php

namespace Smbear\RecordApiLogger\Listeners;

use Illuminate\Support\Str;
use Smbear\RecordApiLogger\Events\RequestEvent;

class RequestListener
{
    public function handle(RequestEvent $event)
    {
        $uniqueId = Str::uuid()->toString();

        $event->request->headers->set('R-Unique-Id', $uniqueId);
    }
}