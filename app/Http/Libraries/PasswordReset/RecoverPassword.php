<?php

namespace App\Http\Libraries\PasswordReset;

use App\Http\Libraries\Functions\StringFunctions;
use Illuminate\Support\Facades\DB;
use Exception;

trait RecoverPassword
{
    use StringFunctions;

    protected function recoverPassword($table, $user){
        $token = $this->createUniqueToken('users', 'password_reset');
        DB::table($table)->where('email', $user->email)->update(['password_reset' => $token]);
        
        $this->sendResetEmail($token, $user);
        return $token;
    }

    protected function sendResetEmail($token, $user){
        $details = [
            'greeting' => "Hi, Reset Your Password",
            'body' => "Here is your Password Reset Token ",
            'link' => "localhost::3000/reset-password/$token",
            'thanks' => 'Copy this token your app to reset your password'
        ];   

        Notification::send($user, new PasswordReset($details));
        return true;
    }
}
