<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Activity;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $route = $request->route()->getName();
        $ipAddress = $request->ip();
        $method = $request->method();
        if ($user) {
            Activity::create([
                'user_id' => $user->id,
                'action' => $method . ' ' . $route,
                'ip_address' => $ipAddress,
                'url' => $request->fullUrl(),
            ]);
        }
        return $next($request);
    }
}