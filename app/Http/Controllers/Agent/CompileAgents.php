<?php

namespace App\Http\Controllers\Agent;

use App\Models\Agent;

trait CompileAgents {


    protected function compileAgents(){
        $data = Agent::where('status', 'active')->get();
        return $this->formatAgentData($data);
    }

    protected function formatAgentData($agents){
        $array = [];

        if (count($agents) > 0 ) {
            foreach ($agents as $key => $agent) {
                $array[] = array_merge($agent->toArray(), [
                    'avatar' => json_decode($agent->avatar),
                ]);
            }
        }

        return $array;
    }  

}