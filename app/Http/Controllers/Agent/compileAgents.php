<?php
namespace App\Http\Controllers\Agent;

trait CompileAgents{

    public function formatAgentData($agents){
        $array = [];
        if (count($agents) > 0) {
            foreach ($agents as $key => $agent) {
                $array[] = array_merge($agent->toArray(), ['avatar' => json_decode($agent->avatar)[0]]);
            }
        }

        return $array;
    }

}
