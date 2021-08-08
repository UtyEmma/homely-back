<?php

namespace App\Http\Middleware;

use App\Http\Libraries\ResponseStatus\ResponseStatus;
use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckForVerifiedEmail
{
    use ResponseStatus;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        try {
            if (!$request->user($role)) { throw new Exception('The Authenticated User does not Exist', 403); }
            if (!$request->user($role)->isVerified) { throw new Exception('User not verified', 403); }
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
        
        return $next($request);
    }
}
