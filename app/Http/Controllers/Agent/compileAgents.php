<?php

namespace App\Http\Controllers\Agent;

use App\Models\Agent;

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

}
