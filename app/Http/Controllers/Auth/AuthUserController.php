<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\LoginRequest;
use App\Http\Requests\Auth\User\SignupRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthUserController extends Controller
{

    public function login(LoginRequest $request){
        if (!$token = JWTAuth::attempt($request->all())) {
            return $this->error(401, 'Invalid Email or Password');
        }

        $user = auth()->user();
        
        return response()->json([
                'status' => false,
                'message' => 'Login Successful',
                'data' => [
                    'token' => $token,
                    'user' => $user ]
            ]);
    }

    public function signup (SignupRequest $request){
        try {
            $user_id = $this->createUniqueToken('users', 'unique_id');
            $h_password = Hash::make($request->password);

            $create_user = User::create(array_merge($request->validated(), 
                                                    ['unique_id' => $user_id,
                                                    'password' => $h_password]));

            $create_user ? $this->verify(User::find($user_id), 'user', false) 
                            : throw new Exception("User Registration Failed", 500);

        } catch (Exception $e) {
           return $this->error(500, $e->getMessage()."::".$e->getLine());
        }

        return $this->success("Sign Up Successful! Verification Email Sent");
    }


    public function remember (){

    }


    public function resendVerificationLink(User $user){
        return $this->verify($user, 'user', true);
    }


    public function logout(){
        Auth::logout();
        return $this->success();
    }


}
