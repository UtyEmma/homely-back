<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Password\ResetPassword;
use App\Http\Requests\Auth\Passwords\ResetPasswordRequest;
use App\Http\Requests\Auth\User\LoginRequest;
use App\Http\Requests\Auth\User\SignupRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthUserController extends Controller{
    use ResetPassword;

    public function login(LoginRequest $request){
        if (!$token = JWTAuth::attempt($request->all())) { 
            return $this->error(401, 'Invalid Email or Password'); 
        }
        $user = auth()->user();
        $current_user = User::find($user->unique_id);

        $avatar = $user->avatar ? $avatar = json_decode($current_user->avatar)[0]->url : $avatar = null;

        return $this->success("Login Successful", [
            'token' => $token, 
            'user' => array_merge($current_user->toArray(), ['avatar' => $avatar])
        ]);
    }

    public function signup (SignupRequest $request){
        try {
            $user_id = $this->createUniqueToken('users', 'unique_id');
            $h_password = Hash::make($request->password);

            User::create(array_merge($request->validated(), 
                                        ['unique_id' => $user_id,
                                        'password' => $h_password]));

            $this->verify(User::find($user_id), 'user', false);
            
        } catch (Exception $e) {
           return $this->error(500, $e->getMessage()."::".$e->getLine());
        }

        return $this->success("Sign Up Successful! Verification Email Sent");
    }


    public function forgotPassword(Request $request){
        try {
            if (!$user = User::where('email', $request->email)->first()) {
                return $this->error(404, "Email Address Does Not Exist");
            }
            $this->sendResetLink($user);
        } catch (Exception $e) {
            return $this->error("Password Reset could not be completed", 500);
        }
        return $this->success("Password Reset Token Sent! Please Check your Email");
    }

    public function resetPassword(ResetPasswordRequest $request){
        try {
            $user = User::where('email', $request->email)->where('password_reset', $request->token)->first();
            if (!$user) {
                throw new Exception("Invalid Password Reset Details", 403);
            }
            
            $user->password = Hash::make($request->password);
            $user->save();

        } catch (Exception $e) {
            return $this->error(401, $e->getMessage());
        }

        $user->password_reset = null;
        $user->save();
        return $this->success("User Password Has been updated");
    }


    public function resendVerificationLink(User $user){
        return $this->verify($user, 'user', true);
    }


    public function logout(){
        Auth::logout();
        return $this->success();
    }


}
