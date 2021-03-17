<?php

namespace Smbear\RecordApiLogger\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Smbear\RecordApiLogger\Events\RequestEvent;
use Smbear\RecordApiLogger\Events\ResponseEvent;
use Smbear\RecordApiLogger\Events\QuerySqlEvent;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class RecordApi extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        event(new RequestEvent($request));

        event(new QuerySqlEvent($request->headers->get('R-Unique-Id')));

        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        event(new ResponseEvent($request,$response));
    }
}