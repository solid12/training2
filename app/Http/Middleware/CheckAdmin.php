<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session('admin')) {
            if ($request->ajax()) {
                return ['success' => false, 'message' => __('You are not logged in !')];
            }else {
                throw new \Exception('Unauthorized');
            }
        }

        return $next($request);
    }
}
