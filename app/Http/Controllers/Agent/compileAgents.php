<?php

namespace App\Http\Controllers\Agent;

use App\Models\Agent;
use App\Models\Chat;
use App\Models\Listing;
use App\Models\Notification;
use App\Models\Review;
use App\Models\Support;

trait CompileAgents {


    protected function compileAgents(){
        $q = Agent::query();

        $q->where('username', '!=', '');
        $q->where('status', 'active');
        $data = $q->get();
        //  = Agent::where('status', 'active')->where('username')->get();
        return $this->formatAgentData($data);
    }

    protected function formatAgentData($agents){
        $array = [];

        if (count($agents) > 0 ) {
            foreach ($agents as $key => $agent) {
                $array[] = $agent;
            }
        }

        return $array;
    }

    protected function clearAgentData($agent){
        $id = $agent->unique_id;
        Listing::where('agent_id', $id)->delete();
        Support::where('agent_id', $id)->delete();
        Chat::where('agent_id', $id)->delete();
        Notification::where('receiver_id', $id)->delete();
        Review::where('agent_id', $id)->delete();
        $agent->delete();
    }

}
