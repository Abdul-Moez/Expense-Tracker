<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class NormalUserKey
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
        if(session::has('normalUserEncryptKey')){
            return $next($request);
        }

        // dd('You have not admin access due to middleware');
        // return redirect('home')->with('error','You have not admin access');
        return redirect('/encryption_key');
        // return redirect('home')->with('error','You have not admin access');
    }
}
