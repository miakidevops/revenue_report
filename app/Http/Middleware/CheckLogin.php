<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;
use Closure;

class CheckLogin
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
        if(session()->has('user_email'))
                                {
                                     //echo "<br> u r in login at present";
                                    //  return new Response(view('middle'));

                                    return redirect('/homePage');
                                   
                                }
                                else{
                                    return $next($request);
                                }
    }
}
