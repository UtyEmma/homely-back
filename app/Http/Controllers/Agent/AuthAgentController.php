<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentLoginRequest;
use App\Http\Requests\Agent\SignupAgentRequest;
use App\Models\Agent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWTGuard;

class AuthAgentController extends Controller
{
    public function login(AgentLoginRequest $request){
        auth()->shouldUse('agent');

        if (!$token = JWTAuth::attempt($request->all())) {
            return $this->error(400, 'Invalid Email or Password');
        }

        $user = auth()->user();

        $agent = array_merge($user->toArray(), [
            'avatar' => json_decode($user->avatar)
        ]);
        
        return $this->success('Login Successful', [
            'token' => $token,
            'user' => $agent
        ]);
    }

    public function signup (SignupAgentRequest $request){
        try {
            $agent_id = $this->createUniqueToken('agents', 'unique_id');
            $h_password = Hash::make($request->password);
            $create_user = Agent::create(array_merge($request->validated(), 
                                                    ['unique_id' => $agent_id,
                                                    'password' => $h_password]));
            
            $create_user ? $this->verify(Agent::find($agent_id)->first(), 'agent', false) 
                            : throw new Exception("Agent Signup Failed", 500);
        } catch (Exception $e) {
           return $this->error(500, $e->getMessage());
        }

        return $this->success("Sign Up Successful");
    }


    public function remember (){

    }


    public function resendVerificationLink(Agent $agent){
        return $this->verify($agent, 'agent', true);
    }

    
    public function logout(){
        auth()->logout();
        return $this->success();
    }
}
