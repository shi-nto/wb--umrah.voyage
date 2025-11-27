<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!auth()->check()) {
            \Log::warning('403 Forbidden: User not authenticated', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);
            abort(403, 'Unauthorized');
        }

        if (!in_array(auth()->user()->role, ['admin', 'agent'])) {
            \Log::warning('403 Forbidden: User does not have required role', [
                'user_id' => auth()->user()->id,
                'user_email' => auth()->user()->email,
                'user_role' => auth()->user()->role,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
