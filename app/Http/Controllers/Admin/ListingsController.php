<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Listings\CompileListing;
use App\Http\Libraries\Notifications\NotificationHandler;
use App\Models\Agent;
use App\Models\Favourite;
use App\Models\Listing;
use App\Models\Notification;
use App\Models\Review;
use Exception;

class ListingsController extends Controller{
    use NotificationHandler, CompileListing;

    public function deleteListing($id){
        if($listing = Listing::find($id)) {
            $agent = Agent::find($listing->agent_id);
            $this->clearListingData($listing, $agent);
        }else{
            return redirect()->back()->with('error', 'Listing Does not Exist!!!');
        }
        return redirect()->back()->with('success', 'Listing Deleted!!!');
    }

    public function suspendListing($id){
        if ($listing = Listing::find($id)) {
            $listing->status = $listing->status === 'active' ? 'suspended' : 'active' ;
            $listing->save();

            $admin = auth()->user();

            $data = [
                'type_id' => $id,
                'message' =>  $listing->status === 'active' ? $listing->title.' has been Restored' : $listing->title.' has been suspended! Please contact Support!',
                'publisher_id' => $admin->unique_id,
                'receiver_id' => $listing->agent_id
            ];

            $this->makeNotification('listing_suspended', $data);

        }else{
            return redirect()->back()->with('error', 'Listing Does not Exist!!!');
        }
        return redirect()->back()->with('success', 'Listing Suspended!!!');
    }

    public function single($id){
        if ($listing = Listing::find($id)) {
            return view('listings.single-listing', $listing);
        }else{
            return redirect()->back()->with('error', 'Listing Does not Exist!!!');
        }
    }

    public function approveListing($id){
        try {
            $admin = auth()->user();
            if (!$listing = Listing::find($id)) { throw new Exception("This Property is Not Found", 404); }
            if ($listing->status !== 'pending') { throw new Exception("This property is already approved", 400); }

            $listing->status = 'active';
            $listing->save();

            $data = [
                'type_id' => $id,
                'message' => 'Your Property has been Approved!',
                'publisher_id' => $admin->unique_id,
                'receiver_id' => $listing->agent_id
            ];

            $this->makeNotification('listing_approved', $data);

        }catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', "The Property has been approved");

    }
}
