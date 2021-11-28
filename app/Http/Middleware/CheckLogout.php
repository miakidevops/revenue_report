<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogout
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
        if (session()->has('user_email')){
            return $next($request);
        }
        else{
            session()->put('rev_rep_prev_url', url()->current());
            return redirect('login');
        }
    }
}
