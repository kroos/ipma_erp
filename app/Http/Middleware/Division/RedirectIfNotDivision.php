<?php

namespace App\Http\Middleware\Division;

use Closure;

class RedirectIfNotDivision
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
        if ( ! $request->user()->accessdivision( $request->route()->uri ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
