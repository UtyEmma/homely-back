<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
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
            return redirect()->back()->with('message', 'Agent Does not Exist!!!');
        }
    }

    public function all(){
        return Agent::all();
    }

    public function deleteAgent($id){
        if ($agent = Agent::find($id)) {
            $agent->delete();
            return redirect()->back()->with('message', "Agent Deleted");
        }else{
            return redirect()->back()->with('message', "Agent does not Exist");
        }
    }

    public function suspendAgent($id){
        if ($agent = Agent::find($id)) {
            $agent->status = !$agent->status;
            $agent->save();
            return redirect()->back()->with('message', "Agent Suspended");
        }else{
            return redirect()->back()->with('message', "Agent does not Exist");
        }
    }
}
