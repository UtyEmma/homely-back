<?php

namespace App\Http\Controllers\Wishlist;

use App\Models\Wishlist;
use App\Models\Agent;


trait CompileWishlist {

    function compileAgentWishlist($agent_id){
        $agent = Agent::find($agent_id);
        $query = Wishlist::query();

        $query->where('city', $agent->city);
        $query->where('state', $agent->state);
        
        return $query->get();
    }
    
}
