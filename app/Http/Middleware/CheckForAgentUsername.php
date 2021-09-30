<?php

namespace App\Http\Middleware;

use App\Http\Libraries\ResponseStatus\ResponseStatus;
use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckForAgentUsername{
    use ResponseStatus;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
        try {
            $user = auth()->user();
            if (!$user->username) { throw new Exception("Please update your username to proceed", 400); }
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
        return $next($request);
    }
}
