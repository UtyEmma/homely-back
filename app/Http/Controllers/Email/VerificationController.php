<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use App\Models\Verification;
use Exception;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

    /**
     * Perform The Email Confirmation with a verification code
     *
     * @param  mixed $code
     * @param  mixed $user_id
     * @return void
     */
     public function verify_email ($code) {
        try {
            if (!$verification = Verification::find($code)) { throw new Exception("Verification Link is Invalid!", 400); }

            $verification->completed = true;
            $verification->save();

            $user = $verification->role === 'tenant' ? User::find($verification->user_id) : Agent::find($verification->user_id);
            if (!$user) { throw new Exception("Invalid Verification Link", 400); }
            $user->isVerified = true;
            $user->save();

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Verification Successful", [
            'type' => $verification->role,
            'status' => true,
            'user' => $user
        ]);
    }

}
