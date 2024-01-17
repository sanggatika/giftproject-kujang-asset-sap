<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use App\Http\Controllers\Helpers\mainController;

//Conect to DB
use App\Models\LogAccessClient;

class LogAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientAgent = mainController::getClientAgent();

        $ipAddress = $request->ip();
        $method = $request->method();
        $access = $request->path();
        
        $dataLog = [
            'uuid' => (string) Str::uuid(),
            'method' => $method,
            'access' => $access,
            'parameter' => null,
            'ip_address' => $ipAddress,
            'browser' => $clientAgent['browser'],
            'browser_version' => $clientAgent['browser_version'],
            'platform' => $clientAgent['platform'],
            'device' => $clientAgent['device'],
            'desktop' => $clientAgent['desktop'],
            'phone' => $clientAgent['phone'],
            'robot' => $clientAgent['robot'],
            'status' => 0,
            'created_at' => Carbon::now('Asia/Jakarta')
        ];
        LogAccessClient::insert($dataLog);

        return $next($request);
    }
}
