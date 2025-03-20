<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->log($request, $response);
    }

    protected function log($request, $response)
    {
        $message = "API Request: {$request->getMethod()} {$request->getUri()}";

        $log = [
            'URI' => $request->getUri(),
            'METHOD' => $request->getMethod(),
            'IP' => $request->getClientIp(),
            'REQUEST_BODY' => $request->all(),
            'RESPONSE' => $response->getContent()
        ];

        Log::channel('daily')->info($message, $log);
    }
}