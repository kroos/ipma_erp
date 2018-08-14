<?php

namespace App\Http\Middleware\Department;

use Closure;

class RedirectIfNotDepartment
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
        // dd( $request->route()->uri );
        if ( ! $request->user()->accessdepartment( $request->route()->uri ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
