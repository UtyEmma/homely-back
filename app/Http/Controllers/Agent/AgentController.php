<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentUpdateRequest;
use App\Models\Agent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Agent\CompileAgents;
use App\Http\Controllers\Listings\CompileListings;

class AgentController extends Controller
{
    use CompileAgents, CompileListings;
    
    public function update(AgentUpdateRequest $request){
        try {
            $agent = $this->agent();
            $files = [];

            $request->hasFile('avatar') ? 
                            $files = $this->handleFiles($request->file('avatar'))
                            : $files = null;

            Agent::find($agent->unique_id)->update(
                        array_merge($request->validated(), ['avatar' => $files])
                    ); 
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $updated_agent = Agent::find($agent->unique_id);
        $agent = array_merge($updated_agent->toArray(), ['avatar' => json_decode($updated_agent->avatar)[0]]);        
        return $this->success("Agent Profile Updated!!!", ['agent' => $agent]);
    }

    public function getLoggedInUser(){
        return $this->success("Logged In User Loaded", $this->agent());
    }

    public function single($id){
        try {
            $agent = Agent::find($id) ? Agent::find($id) : throw new Exception("User Not Found", 404);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        } 

        $listings = Agent::find($id)->listings;
        $reviews = Agent::find($id)->reviews;

        $formatted_agent = array_merge($agent->toArray(), [
                            'avatar' => json_decode($agent->avatar),
                        ]);

        $formatted_listings = $this->formatListingData($listings);

        return $this->success("Agent Fetched", [
            'agent' => $formatted_agent,
            'listing' => $formatted_listings,
            'reviews' => $reviews
        ]);
    }

    public function show(){
        try {
            $agents = $this->compileAgents();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("All Agents", [
            'agents' => $agents
        ]);
    }

    public function deleteUserAccount(Agent $agent){
        try {
            Auth::logout();
            $agent->delete();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
        return $this->success('Account Deleted');
    }
}
