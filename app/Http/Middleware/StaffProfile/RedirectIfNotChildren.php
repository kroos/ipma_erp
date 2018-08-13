<?php

namespace App\Http\Middleware\StaffProfile;

use Closure;

class RedirectIfNotChildren
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
        // dd( $request->route()->staffChild->staff_id );
        if ( ! $request->user()->editStaffChildren( $request->route()->staffChild->staff_id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
