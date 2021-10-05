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

        // foreach ($agents as $key => $value) {
            // $agent = Agent::find($value['unique_id']);
        $this->sendNotification($agents, $wishlist);
        // }

        return true;
    }

    private function compileAgents($wishlist){
        $agents = [];
        $agents = Agent::where('city', $wishlist->city)->where('status', 'active')->get();

        if (count($agents) < 20) {
            $agents = Agent::where('state', $wishlist->state)->where('status', 'active')->get();
        }

        return $agents;
    }

    private function sendNotification ($agents, $wishlist){
        try {
            $details = $this->notificationDetails($wishlist);
            Notification::send($agents, new SendWishlistToAgent($details));
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return true;
    }

    private function notificationDetails($wishlist){
        $user = User::find($wishlist->user_id);
        $details = [
            'greeting' => $user->firstname." is is looking for a property around your location.",
            'body' => "Description: $wishlist->desc; Property Type: $wishlist->category",
            'link' => env('FRONTEND_URL')."/agent-wishlist",
            'thanks' => 'Thank you for being a part of BayOf'
        ];
        return $details;
    }



}
