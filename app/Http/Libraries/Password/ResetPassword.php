<?php

namespace App\Http\Libraries\Password;

use App\Models\Agent;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\PasswordReset;
use Exception;

trait ResetPassword {

    protected function sendResetLink($user){
        try{
            $token = rand(10001, 99999);
            $user->where('email', $user->email)->update(['password_reset' => $token]);
            $this->sendResetEmail($token, $user);
        }catch(Exception $e){
            throw new Exception($e->getMessage(), 500);
        }    
        return $token;
    }

    private function sendResetEmail($token, $user){
        $username = $user->firstname;
        try {
            Notification::send($user, new PasswordReset($token, $username));
        } catch (Exception $e) {
            throw new Exception("Password Emails could not be Sent!!!", 500);
        }
        return true;
    }
}