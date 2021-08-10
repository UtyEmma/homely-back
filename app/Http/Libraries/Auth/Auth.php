<?php

namespace App\Http\Libraries\Auth;

use App\Models\Agent;
use Illuminate\Support\Facades\Auth as AuthUser;
use Tymon\JWTAuth\Facades\JWTAuth;

trait Auth{ 

    public function tenant(){
        auth()->shouldUse('api');
        return AuthUser::guard('api')->user();
    }

    public function agent(){
        auth()->shouldUse('agent');
        return AuthUser::guard('agent')->user();
    }
    
}