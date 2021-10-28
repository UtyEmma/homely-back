<?php

namespace App\Http\Libraries\Password;

use App\Models\Agent;
use App\Models\User;
use App\Notifications\PasswordReset;
use Exception;
use Illuminate\Support\Facades\Notification;

trait ResetPassword {

    private function sendResetEmail($token, $user){
        $firstname = $user->firstname;
        try {
            Notification::send($user, new PasswordReset($token, $firstname));
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return true;
    }
}
