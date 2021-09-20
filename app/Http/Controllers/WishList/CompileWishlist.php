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

        $wishlists = array_map(function($item){
            $user = User::find($item['user_id']);
            return [
                'wishlists' => $item,
                'user' => array_merge($user->toArray(), [
                    'avatar' => $user->avatar ? json_decode($user->avatar)[0] : null
                ])
            ];
        }, $all->toArray());

        return $wishlists;
    }

}
