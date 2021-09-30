<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Social\SocialAuthRequest;
use App\Models\Agent;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{
    public function handleAuth(SocialAuthRequest $request){
        try {
            $user_data = $request->filled('accessToken')
                ? $this->authWithToken($request->driver, $request->accessToken)
                    : $this->tokenlessAuth($request->driver, $request);

            if (!$user = $this->checkForExistingUser($user_data, $request->type)) {
                if($request->type === 'tenant'){
                    $user = $this->createTenant($user_data);
                }elseif ($request->type === 'agent') {
                    $user = $this->createAgent($user_data);
                }else {
                    throw new Exception("Invalid Authentication Request", 400);
                }
            }

            auth()->shouldUse($request->type);
            $token = Auth::login($user);

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage()." : ".$e->getLine());
        }

        return $this->success("Log In Successful", [
            'user' => $user,
            'token' => $token,
            'type' => $request->type
        ]);
    }

    private function createAgent($agent_data){
        $unique_id = $this->createUniqueToken('agents', 'unique_id');
        Agent::create(array_merge($agent_data, ['unique_id' => $unique_id]));
        return Agent::find($unique_id);
    }

    private function createTenant($user_data){
        $unique_id = $this->createUniqueToken('users', 'unique_id');
        User::create(array_merge($user_data, ['unique_id' => $unique_id]));
        return User::find($unique_id);
    }

    private function checkForDriver($user, $driver){
        return $user->auth_driver === $driver ? true : false;
    }

    private function checkForExistingUser($user, $type){
        if ($type === 'tenant') {
            return User::where('email', $user['email'])->first();
        }elseif ($type === 'agent') {
            return Agent::where('email', $user['email'])->first();
        }
    }

    private function authWithToken($driver, $token){
        $auth = Socialite::driver($driver)->userFromToken($token);
        return $this->extractUserData($auth->user, $driver);
    }

    private function tokenlessAuth($driver, $data){
        return $this->extractUserData((array) $data, $driver);
    }

    private function extractUserData($data, $driver){
        $user_data = [
            'firstname' => $data['given_name'],
            'lastname' => $data['family_name'],
            'email' => $data['email'],
            'isVerified' => (bool) $data['email_verified'],
            'avatar' => $data['picture'],
            'auth_driver' => $driver
        ];
        return $user_data;
    }


}
