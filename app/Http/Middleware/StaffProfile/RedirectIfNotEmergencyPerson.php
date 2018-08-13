<?php

namespace App\Http\Middleware\StaffProfile;

use Closure;

class RedirectIfNotEmergencyPerson
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
        // dd( $request->route()->staffEmergencyPerson->staff_id );
        if ( ! $request->user()->editStaffEmergencyPerson( $request->route()->staffEmergencyPerson->staff_id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
