<?php

namespace App\Http\Middleware;

use App\Http\Libraries\ResponseStatus\ResponseStatus;
use App\Models\Admin;
use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckForValidAdmin
{
    use ResponseStatus;

    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->bearerToken() ?: throw new Exception("Invalid Request! Authentication Header not Present", 500);
            $admin = json_decode(base64_decode($token));
            
            if (!$admin->unique_id && !Admin::find($admin->unique_id)) {
                throw new Exception("The authenticated user does not Exist", 401); 
            } 
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
        
        return $next($request);
    }
}
