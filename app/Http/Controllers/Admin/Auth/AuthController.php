<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AdminLoginRequest;
use App\Http\Requests\Admin\Auth\AdminSignupRequest;
use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login (AdminLoginRequest $request){
        if (!auth('web')->attempt($request->validated())) {
               return redirect()->back()->with('message', "Incorrect Email or Password");
        }
        

        return redirect('/');
    }

    public function signup(AdminSignupRequest $request){

        try {
            $unique_id = $this->createUniqueToken('admins', 'unique_id');
            $h_password = Hash::make($request->password);
    
            Admin::create(array_merge($request->validated(), [
                'unique_id' => $unique_id, 'password' => $h_password
            ]));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('login')->with('message', 'Admin Registration Successful');
    }

    public function logout(){
        // auth()->logout();
        Auth::guard('web')->logout();
        return redirect('login');
    }


}
