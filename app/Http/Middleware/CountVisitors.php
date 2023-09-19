<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CountVisitors
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
        // Register new visitor
        Visitor::updateOrCreate(['user_ip' => $request->ip(), 'visited_at' => Carbon::now()->toDateString()]);

        return $next($request);
    }
}
