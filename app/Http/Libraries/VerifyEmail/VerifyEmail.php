<?php
namespace App\Http\Libraries\VerifyEmail;

use App\Http\Libraries\ResponseStatus\ResponseStatus;
use App\HTTP\Libraries\Token\Token;
use App\Models\Verification;
use App\Notifications\EmailVerification;
use Exception;
use Illuminate\Support\Facades\Notification;

trait VerifyEmail {
    use ResponseStatus, Token;

    private $id;

    protected function verify($user, $role, $resend){
        $this->id = $user->unique_id;
        $this->checkVerificationStatus($user);

        $verification_id = $this->createVerificationInstance($role);
        $sendEmail = $this->sendVerificationEmail($verification_id, $user);
        // return $sendEmail;

        if($sendEmail){
            return $resend ? $this->success("Verification Email Sent")
                            : $this->success("A New Verification Email has been Sent");
        };

    }


    private function checkVerificationStatus($user){
        if($user->isVerified){ new Exception("Your Email is Verified", 400); }
        $this->checkVerificationAttempt($this->id);
    }


    private function checkVerificationAttempt($user_id){
        $has_user = Verification::where('user_id', $user_id)->first();
        return $has_user && $has_user->delete();
    }


    private function createVerificationInstance ($role){
        $unique_id = $this->createUniqueToken('verifications', 'unique_id');
        Verification::create([
            'unique_id' => $unique_id,
            'user_id' => $this->id,
            'role' => $role,
            'type' => 'email',
            'completed' => false
        ]);
        return $unique_id;
    }

    private function sendVerificationEmail($verification_id, $user){
        $details = [
            'greeting' => "Hi ".$user->firstname,
            'body' => "Click the button below to verify your email",
            'link' => env('FRONTEND_URL')."/email/verify/".$verification_id,
            'thanks' => 'Copy this token your app to reset your password'
        ];
        // return $user->firstname;

        try {
            Notification::send($user, new EmailVerification($details));
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return true;
    }

}
