<?php

namespace App\Http\Middleware\StaffProfile;

use Closure;

class RedirectIfNotOwnerChangePassword
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
        // dd( $request->route()->login->id );
        // dd( $request->user()->onlyOwnerChangePassword(56) );
        if ( ! $request->user()->onlyOwnerChangePassword( $request->route()->login->id ) ) {
            return redirect()->back();
        }
        return $next($request);
    }
}
