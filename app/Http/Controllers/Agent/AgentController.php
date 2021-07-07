<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentUpdateRequest;
use App\Models\Agent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function update(AgentUpdateRequest $request){
        try {
            
            $request->hasFile('avatar') ? $files = $this->upload($request->file('avatar'), 'user')
                                        : $files = [];

            Agent::find($this->user->id)->update(
                        array_merge($request->validated(), ['files' => $files])
                    ); 

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Agent Profile Updated!!!");
    }


    public function getLoggedInUser(){
        return $this->success("Logged In User Loaded", $this->user);
    }

    public function show(Agent $agent){
        return !$agent ? $this->error(404, "User Not Found") : $this->success("Agent Fetched", $agent);
    }

    public function deleteUserAccount(Agent $agent){
        try {
            $agent->delete();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        Auth::logout();

        return $this->success('Account Deleted');
    }
}
