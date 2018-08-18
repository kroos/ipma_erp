<?php

namespace App\Http\Middleware\StaffLeave;

use Closure;

class RedirectIfNotOwnerLeave
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
        // dd($request->route()->staffLeave->staff_id );
        // route is changing frpm RedirectNotOwner
        if ( ! $request->user()->isOwner( $request->route()->staffLeave->staff_id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
