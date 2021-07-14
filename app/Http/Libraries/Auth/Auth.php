<?php

namespace App\Http\Libraries\Auth;

use App\Models\Agent;
use Illuminate\Support\Facades\Auth as AuthUser;

trait Auth{ 

    public function tenant(){
        return AuthUser::user();
    }

    public function agent(){
        AuthUser::shouldUse('agent');
        return AuthUser::guard('agent')->user();
    }
    
}