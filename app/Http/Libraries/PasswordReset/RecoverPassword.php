<?php

namespace App\Http\Libraries\PasswordReset;

use App\Http\Libraries\Functions\StringFunctions;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Notification;

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
        Notification::send($user, new PasswordReset($token, $user->username));
        return true;
    }
}
