<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\Listing;
use App\Models\Notification;
use App\Models\Review;
use App\Models\Support;
use Exception;
use Illuminate\Support\Facades\Request;

class AdminController extends Controller{

    function verifyAdmin ($id) {
        try {
            $admin = Admin::find($id) ?: throw new Exception("Admin Verification Aborted! Invalid Details Given!", 404 );
            $admin->isLoggedIn ?: throw new Exception("Please login to your Admin Dashboard to activate Admin Mode", 400);

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Admin Mode Activated", [
            'type' => 'admin',
            'token' =>  base64_encode(json_encode($admin))
        ]);
    }

    public function adminDeleteAgent($agent_id){
        try {
            if(!$agent = Agent::find($agent_id)){ throw new Exception("Agent Not Found", 404); }

            Listing::where('agent_id', $agent_id)->delete();
            Notification::where('receiver_id', $agent_id)->delete();
            Support::where('agent_id', $agent_id)->delete();
            Review::where('agent_id', $agent_id)->delete();

            $agent->delete();


        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Agent Deleted");
    }


    public function adminDeleteListing($listing_id){
        try {
            if(!$listing = Listing::find($listing_id)){ throw new Exception("Listing Not Found", 404); }
            Notification::where('type_id', $listing_id)->delete();
            Review::where('listing_id', $listing_id)->delete();
            $listing->delete();

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Listing Deleted");
    }
}
