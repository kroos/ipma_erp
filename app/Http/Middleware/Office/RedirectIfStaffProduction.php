<?php
namespace App\Http\Middleware\Office;

use Closure;

class RedirectIfStaffProduction
{
	public function handle($request, Closure $next)
	{
		// dd( $request->route() );
		if ( ! $request->user()->isoffice( 1 ) ) {
			return redirect()->back();
		}
		return $next($request);
	}
}
