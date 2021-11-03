<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Password\ResetPassword;
use App\Http\Requests\Auth\User\LoginRequest;
use App\Http\Requests\Auth\User\SignupRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthUserController extends Controller{
    use ResetPassword;

    public function login(LoginRequest $request){
        if (!$token = JWTAuth::attempt($request->all())) {
            return $this->error(400, 'Invalid Email or Password');
        }

        $user = auth()->user();

        return $this->success("Login Successful", [
            'token' => $token,
            'user' => $user
        ]);
    }

    public function signup (SignupRequest $request){
        try {
            $user_id = $this->createUniqueToken('users', 'unique_id');
            $h_password = Hash::make($request->password);

            User::create(array_merge($request->validated(),
                                        ['unique_id' => $user_id,
                                        'password' => $h_password]));

            $verify = $this->verify(User::find($user_id), 'tenant', false);
            // return $verify;

        } catch (Exception $e) {
           return $this->error($e->getCode(), $e->getMessage()."::".$e->getLine());
        }

        return $this->success("Sign Up Successful! Check your Inbox for our Verification Email.");
    }

    public function resendVerificationLink($user){
        try {
            if (!$user = User::find($user)) { throw new Exception("Tenant Not Found", 404); }
            if ($user->isVerified) { throw new Exception("Your Email is verified already! Proceed to login.", 400); }
            return $this->verify($user, 'tenant', true);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
    }

    public function getLoggedInUser () {
        $auth = auth()->user();
        $user = User::find($auth->unique_id);
        $avatar = $user->avatar ? json_decode($user->avatar)[0] : null;

        return $this->success("", [
            'user' => array_merge($user->toArray(), ['avatar' => $avatar])
        ]);
    }


    public function logout(){
        Auth::logout();
        return $this->success();
    }


}
