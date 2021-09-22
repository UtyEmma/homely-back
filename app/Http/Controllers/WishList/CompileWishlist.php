<?php

namespace App\Http\Controllers\WishList;

use App\Models\Wishlist;
use App\Models\Agent;
use App\Models\User;

trait CompileWishlist {

    function compileAgentWishlist($agent_id){
        $agent = Agent::find($agent_id);
        $query = Wishlist::query();

        $query->where('city', $agent->city);
        $query->where('state', $agent->state);
        $all = $query->get();

        $wishlists = array_map(function($wishlist){
            $user = User::find($wishlist['user_id']);
            return [
                'wishlists' => $wishlist,
                'user' => $user
            ];
        }, $all->toArray());

        return $wishlists;
    }

}
