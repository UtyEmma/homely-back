<?php

namespace App\Http\Controllers\Listings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Listings\CreateListingRequest;
use App\Models\Agent;
use App\Models\Listing;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function createListing(CreateListingRequest $request){

        $listing_id = $this->createUniqueToken('listings', 'unique_id');
        $details = json_encode($request->details);
        $features = json_encode($request->features);

        Listing::create(array_merge($request->all(), [
                                    'unique_id' => $listing_id,
                                    'agent_id' => $this->agent()->unique_id,
                                    'details' => $details,
                                    'features' => $features
                                    ]));
    

        return $this->success("Listing has been added Successfully");
    }

    // Get a User's Listings
    public function getUserListings(){
        $agent = $this->agent();
        try {
            $listings = Agent::find($agent->unique_id)->listings;
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Listings Loaded", $listings);
    }

    // Select active LIstings
    public function getActiveListings(){
        try {
            $active_listings = User::find($this->user->user_id)
                                ->where('active', false)->listings;
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Active Listings Loaded", $active_listings);
    }

    // Delete a Single Listing
    public function deleteListing(Listing $listing_id){
        try {
            $listing_id->delete();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Listing Deleted");   
    }

    // Get a single Listing
    public function getSingleListing(Listing $listing_id){
        try {
            if (!$listing_id) {
                throw new Exception("The Requested Listing Does Not Exist", 500);
            } 
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Listing Loaded", $listing_id);
    }

}
