<?php

namespace App\Http\Middleware\StaffProfile;

use Closure;

class RedirectIfNotOwner
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
        if ( ! $request->user()->isOwner( $request->route()->staff->id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
