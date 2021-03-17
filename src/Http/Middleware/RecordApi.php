<?php

namespace Smbear\RecordApiLogger\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Smbear\RecordApiLogger\Events\RequestEvent;
use Smbear\RecordApiLogger\Events\ResponseEvent;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class RecordApi extends Middleware
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        event(new RequestEvent($request));

        $response = $next($request);

        event(new ResponseEvent($request,$response));

        return $response;
    }
}