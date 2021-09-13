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
     * To Actually Perform The Verification
     *
     * @param  mixed $code
     * @param  mixed $user_id
     * @return void
     */
     public function verify_email ($code) {
        try {

            if (!$verification = Verification::find($code)) { throw new Exception("Verification Link is Invalid!", 400); } 
            if(!$verification->completed){ throw new Exception("Your account has been verified. Please return to the App", 400); }

        } catch (Exception $e) {
            return $this->error(400, $e->getMessage());
        }

        $verification->completed = true;
        $verification->save();

        $user = $verification->role === 'tenant' ? User::find($verification->user_id) : Agent::find($verification->user_id);         
        $user->isVerified = true;
        $user->save();

        return $this->success("Verification Successful", [
            'type' => $verification->role,
            'status' => true
        ]);
    }

}
