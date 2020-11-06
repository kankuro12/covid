<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->headers->has('xpsu')){
            if($request->header('xpsu', 'ss')=="12345678"){
                return $next($request);
            }else{
                return response("Wrong Api Key",401);
            }
        }else{

            return response("Api Key Not Found",401);
        }
    }
}
