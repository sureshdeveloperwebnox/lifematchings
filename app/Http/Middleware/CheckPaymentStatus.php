<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckPaymentStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $isFreePackageEnabled = get_setting('free_package_activation') == 1;

        if( Auth::user()->isInitialPaymentPaid == 1 || ($isFreePackageEnabled && Auth::user()->member && Auth::user()->member->current_package_id == 1) || Auth::user()->membership == 2) {
            return $next($request);
        } else {
            return redirect()->route('initialPaymentpackage');
        }
    }
}
