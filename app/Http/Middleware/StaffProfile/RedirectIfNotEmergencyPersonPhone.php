<?php

namespace App\Http\Middleware\StaffProfile;

use Closure;

class RedirectIfNotEmergencyPersonPhone
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
        // dd( $request->route()->staffEmergencyPersonPhone->belongtoemergencyperson->get() );
        // dd( $request->user()->editStaffEmergencyPersonPhone('1') );
        if ( ! $request->user()->editStaffEmergencyPersonPhone( $request->route()->staffEmergencyPersonPhone->belongtoemergencyperson->staff_id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
