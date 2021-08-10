<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentUpdateRequest;
use App\Models\Agent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Agent\CompileAgents;

class AgentController extends Controller
{
    public function update(AgentUpdateRequest $request){
        try {
            $agent = $this->agent();
            $files = [];

            $request->hasFile('avatar') ? 
                            $files = $this->handleFiles($request->file('avatar'))
                            : $files = null;

            Agent::find($agent->unique_id)->update(
                        array_merge($request->validated(), ['avatar' => $files])); 
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $updated_agent = Agent::find($agent->unique_id);
        $agent_data = array_merge($updated_agent->toArray(), ['avatar' => json_decode($updated_agent->avatar)[0]]);        
        return $this->success("Agent Profile Updated!!!", ['agent' => $agent_data]);
    }


    public function getLoggedInUser(){
        return $this->success("Logged In User Loaded", $this->user);
    }


    public function single($agent){
        return !$agent = Agent::find($agent) ? $this->error(404, "User Not Found") : $this->success("Agent Fetched", $agent);
    }

    public function show(){
        try {
            $array = [];
            $data = Agent::all();

            $agents = $this->formatAgentsData($data);

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("All Agents", [
            'agents' => $agents,
            'count' => count($agents)
        ]);
    }

    public function deleteUserAccount($agent){
        try {
            if(!$agent = Agent::find()){ throw new Exception("Agent was not found", 404); }
            $agent->delete();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
        Auth::logout();
        return $this->success('Account Deleted');
    }
}
