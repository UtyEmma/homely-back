<?php

namespace App\Http\Controllers\WishList;

use App\Models\Agent;
use App\Models\User;
use App\Notifications\SendWishlistToAgent;
use Exception;
use Illuminate\Support\Facades\Notification;

trait WishlistNotificationHandler{

    protected function sendWishlistToAgents($wishlist) {
        $agents = $this->compileAgents($wishlist);

        foreach ($agents as $key => $agent) {
            $this->sendNotification($agent, $wishlist);
        }

        return true;
    }

    private function compileAgents($wishlist){
        $agents = [];
        $agents = Agent::where('city', $wishlist->city)->where('status', 'active')->get();
        return $agents;
        if (count($agents) < 20) {
            $agents = array_merge($agents->toArray(), Agent::where('state', $wishlist->state)->where('status', 'active')->get()->toArray());
        }

        return $agents;
    }

    private function sendNotification ($agent, $wishlist){
        $details = $this->notificationDetails($wishlist);
        try {
            Notification::send($agent, new SendWishlistToAgent($details));
        } catch (Exception $e) {
            return throw new Exception($e->getMessage(), 500);
        }
        return true;
    }

    private function notificationDetails($wishlist){
        $user = User::find($wishlist->user_id);
        $details = [
            'greeting' => $user->firstname." is is looking for a property around your location.",
            'body' => "Description: $wishlist->desc; Property Type: $wishlist->category",
            'link' => "https:://localhost::3000/agent-wishlist/$wishlist->wishlist_id",
            'thanks' => 'Thank you for being a part of BayOf'
        ];
        return $details;
    }



}
