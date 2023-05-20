<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
       // dd($request->user());
        if ($request->user() && !$request->user()->isAdmin()) {
            return redirect()->route('access-denied'); // Replace 'access-denied' with the route name or URL you want to redirect to
        }
    
        return $next($request);
    }
}
