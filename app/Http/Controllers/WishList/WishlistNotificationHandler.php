<?php

namespace App\Http\Controllers\WishList;

use App\Models\Agent;
use App\Models\User;
use App\Models\Wishlist;
use App\Notifications\SendWishlistToAgent;
use Exception;
use Illuminate\Support\Facades\Notification;

trait WishlistNotificationHandler{

    protected function sendWishlistToAgents($wishlist) {
        $agents = $this->compileAgents($wishlist);
        $this->sendNotification($agents, $wishlist);
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
            'area' => $wishlist->area,
            'category' => $wishlist->category,
            'city' => $wishlist->city,
            'desc' => $wishlist->desc,
            'state' => $wishlist->state,
            'link' => env('FRONTEND_URL')."/agent-wishlist"
        ];
        return $details;
    }



}
