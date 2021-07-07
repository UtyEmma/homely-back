<?php

namespace App\Http\Middleware;

use App\Http\Libraries\Status\Status;
use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckForVerifiedEmail
{
    use Status;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!$request->user('api')) {
                throw new Exception('The Authenticated User does not Exist', 401);
            }
            if (!$request->user('api')->isVerified) {
               throw new Exception('User not verified', 401);
            }
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
        
        return $next($request);
    }
}
