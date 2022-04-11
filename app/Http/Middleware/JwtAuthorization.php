<?php

namespace App\Http\Middleware;

use App\Http\Services\Jwt;
use Closure;

class JwtAuthorization
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
        $token = $request->bearerToken();
        $jwt= new Jwt();
        if($jwt->is_jwt_valid($token)=="true"){
            return $next($request);
        }
        return response(['message'=>'authorization failed']);
    }
}
