<?php

namespace App\Http\Middleware\StaffProfile;

use Closure;

class RedirectIfNotSpouse
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
        // dd( $request->route()->staffSpouse->staff_id );
        if ( ! $request->user()->editStaffSpouse( $request->route()->staffSpouse->staff_id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
