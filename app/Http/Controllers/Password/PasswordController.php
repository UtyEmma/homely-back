<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Functions\DateFunctions;
use App\Http\Libraries\Password\ResetPassword;
use App\Http\Requests\Auth\Passwords\RecoverPasswordRequest;
use App\Http\Requests\Auth\Passwords\ResetPasswordRequest;
use App\Models\Agent;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller{
    use ResetPassword, DateFunctions;

    public function recoverPassword(RecoverPasswordRequest $request){
        try {
            $token = $this->createRandomToken();
            if ($request->type === 'tenant') {
                $user = User::where('email', $request->email)->first();
            }elseif ($request->type === 'agent') {
                $user = Agent::where('email', $request->email)->first();
            }

            if (!$user) { throw new Exception("Email Address does not Exist"); }

            $user->password_reset = $token;
            $user->save();

            $this->sendResetEmail($token, $user);
            

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Password Reset Token Sent!!!", ['status' => true]);
    }



    public function resetPassword(ResetPasswordRequest $request){
        try {

            if ($request->type === 'tenant') {
                $user = User::where('email', $request->email)->where('password_reset', $request->token)->first();
            }elseif ($request->type === 'agent') {
                $user = Agent::where('email', $request->email)->where('password_reset', $request->token)->first();
            }

            if (!$user) {
                throw new Exception("Invalid Password Reset Details", 400);
            }

            // Check for the last time the model was modified inorder to check for token expiry
            $tokenLifetime = $this->timeDiffInHours($user->updated_at, Date::now());

            // if ($tokenLifetime > 24) {
            //     throw new Exception("Password Reset Token has Expired!!!", 400);
            // }
            
            $user->password = Hash::make($request->password);
            $user->password_reset = null;
            $user->save();

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage()." @ ".$e->getLine());
        }

        return $this->success("User Password Has been updated", $request->type);
    }
    
}
