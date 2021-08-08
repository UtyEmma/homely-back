<?php

namespace App\Http\Libraries\Auth;

use App\Models\Agent;
use Illuminate\Support\Facades\Auth as AuthUser;
use Tymon\JWTAuth\Facades\JWTAuth;

trait Auth{ 

    public function tenant(){
        auth()->shouldUse('tenant');
        return AuthUser::guard('tenant')->user();
    }

    public function agent(){
        auth()->shouldUse('agent');
        return AuthUser::guard('agent')->user();
    }
    
}