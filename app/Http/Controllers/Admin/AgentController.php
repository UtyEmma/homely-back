<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Listing;
use Exception;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function single($id){
        if ($agent = Agent::find($id)) {
            return view('agents.single-agent', [
                'agent' => $agent,
                'admin' => auth()->user()
            ]);
        }else{
            return redirect()->back()->with('error', 'Agent Does not Exist!!!');
        }
    }

    public function all(){
        return Agent::all();
    }

    public function deleteAgent($id){
        if ($agent = Agent::find($id)) {
            Listing::where('agent_id', $id)->delete();
            $agent->delete();
            return redirect()->back()->with('success', "Agent Deleted");
        }else{
            return redirect()->back()->with('error', "Agent does not Exist");
        }
    }

    public function suspendAgent($id){
        if ($agent = Agent::find($id)) {
            $agent->status = $agent->status === 'active' ? 'suspended' : 'active';
            $agent->save();
            return redirect()->back()->with('success', "Agent $agent->status");
        }else{
            return redirect()->back()->with('error', "Agent does not Exist");
        }
    }

    public function verifyAgent($id){
        if ($agent = Agent::find($id)) {
            $agent->verified = !$agent->verified;
            $agent->save();
            return redirect()->back()->with('success', Agent::find($id)->verified ? "Agent Verified" : "Agent Unverified");
        }else{
            return redirect()->back()->with('$error', "Agent does not exist");
        }
    }


    public function confirmAgentEmail($id){
        if ($agent = Agent::find($id)) {
            $agent->isVerified = true;
            $agent->save();
            return redirect()->back()->with('success', "Agent Email Verified");
        }else{
            return redirect()->back()->with('$error', "Agent does not exist");
        }
    }


}
