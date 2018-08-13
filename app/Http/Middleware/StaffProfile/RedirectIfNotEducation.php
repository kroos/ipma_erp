<?php

namespace App\Http\Middleware\StaffProfile;

use Closure;

class RedirectIfNotEducation
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
        // dd( $request->route()->staffEducation->staff_id );
        if ( ! $request->user()->editStaffEducation( $request->route()->staffEducation->staff_id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
