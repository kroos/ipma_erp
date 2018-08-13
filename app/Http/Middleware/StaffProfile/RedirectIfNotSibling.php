<?php

namespace App\Http\Middleware\StaffProfile;

use Closure;

class RedirectIfNotSibling
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
        // dd( $request->route()->staffSibling->staff_id );
        if ( ! $request->user()->editStaffSibling( $request->route()->staffSibling->staff_id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
