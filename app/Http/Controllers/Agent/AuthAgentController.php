<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Password\ResetPassword;
use App\Http\Requests\Agent\AgentLoginRequest;
use App\Http\Requests\Agent\SignupAgentRequest;
use App\Http\Requests\Auth\Passwords\ResetPasswordRequest;
use App\Models\Agent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthAgentController extends Controller
{

    use ResetPassword;

    public function login(AgentLoginRequest $request)
    {
        auth()->shouldUse('agent');

        if (!$token = JWTAuth::attempt($request->all())) {
            return $this->error(400, 'Invalid Email or Password');
        }

        $agent = auth()->user();

        return $this->success('Login Successful', [
            'token' => $token,
            'user' => $agent
        ]);
    }

    public function signup(SignupAgentRequest $request)
    {
        try {
            $agent_id = $this->createUniqueToken('agents', 'unique_id');
            $h_password = Hash::make($request->password);

            Agent::create(array_merge($request->validated(), [
                'unique_id' => $agent_id,
                'password' => $h_password
            ]));

            $verify = $this->verify(Agent::find($agent_id), 'agent', false);
            // return $verify;

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Account created successfully! Proceed to confirm email.");
    }

    public function getLoggedInUser()
    {
        return $this->success("", ['user' => auth()->user()]);
    }


    public function forgotPassword(Request $request)
    {
        try {
            if (!$user = Agent::where('email', $request->email)->first()) {
                return $this->error(404, "Email Address Does Not Exist");
            }
            $this->sendResetLink($user);
        } catch (Exception $e) {
            return $this->error("Password Reset could not be completed", 500);
        }

        return $this->success("Password Reset Token Sent! Please Check your Email");
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            if (!$user = Agent::where('email', $request->email)->where('password_reset', $request->token)->first()) {
                throw new Exception("Invalid Password Reset Details", 400);
            }

            $user->password = Hash::make($request->password);
            $user->save();
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        $user->password_reset = null;
        $user->save();

        return $this->success("Your Password has been reset");
    }

    public function resendVerificationLink($agent_id)
    {
        if (!$agent = Agent::find($agent_id)) {
            return $this->error(404, "The agent does not exist");
        }
        return $this->verify($agent, 'agent', true);
    }


    public function logout()
    {
        Auth::logout();
        return $this->success();
    }
}
