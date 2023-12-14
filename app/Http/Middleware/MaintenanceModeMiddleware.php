<?php

namespace App\Http\Middleware;

use App\CPU\Helpers;
use Closure;

class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Log::info(url()->current());
        if(
            (url()->current() != 'http://kof.subeza.com/privacy-n-policy' || url()->current() != 'https://kof.subeza.com/privacy-n-policy')
                && 
                    (url('/') == 'http://kof.subeza.com' || url('/') == 'https://kof.subeza.com')
        ){
            return view('none');
        }
        
        $maintenance_mode = Helpers::get_business_settings('maintenance_mode') ?? 0;
        if ($maintenance_mode) {
            return redirect()->route('maintenance-mode');
        }
        return $next($request);
    }
}
