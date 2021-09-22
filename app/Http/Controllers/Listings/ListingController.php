<?php

namespace App\Http\Controllers\Listings;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Notifications\NotificationHandler;
use App\Http\Requests\Listings\CreateListingRequest;
use App\Models\Agent;
use App\Models\Listing;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;

class ListingController extends Controller{

    use CompileListing, NotificationHandler;

    public function createListing(CreateListingRequest $request){
        try {
            $agent = auth()->user();

            $files = $request->hasFile('images') ? $this->handleFiles($request->file('images')) : [];
            $inital_fees = $request->rent + $request->extra_fees;

            $listing_id = $this->createUniqueToken('listings', 'unique_id');
            $slug = $this->createDelimitedString($request->title, ' ', '-');

            Listing::create(array_merge($request->all(), [
                                            'unique_id' => $listing_id,
                                            'agent_id' => $agent->unique_id,
                                            'amenities' => json_encode($request->amenities),
                                            'images' => $files,
                                            'slug' => strtolower($slug),
                                            'initial_fees' => $inital_fees
                                        ]));

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage()." :--- ".$e->getLine());
        }

        $agent = Agent::find($agent->unique_id);
        $agent->no_of_listings = $agent->no_of_listings + 1;
        $agent->save();

        $listing = Listing::find($listing_id);

        $data = [
            'type_id' => $listing_id,
            'message' => 'Your Property has been submitted and is being reviewed',
            'publisher_id' => $agent->unique_id,
            'receiver_id' => $agent->unique_id,
        ];

        $this->makeNotification('listing', $data);

        return $this->success($request->title." has been added to your Listings", [
            'listing' => array_merge($listing->toArray(), ['images' => json_decode($listing->images)])
        ]);
    }


    public function getAgentsListings(){
        try {
            $agent = auth()->user();
            $array = [];
            $listings = Agent::find($agent->unique_id)->listings;
            $i = 0;

            if (count($listings) > 0) {
                foreach ($listings as $listing) {
                    $array[$i] = array_merge($listing->toArray(), [
                                    'image' => json_decode($listing->images),
                                    'amenities' => json_decode($listing->amenities),
                                    'created_at' => $this->parseTimestamp($listing->created_at)->date
                                ]);
                    $i++;
                }
            }

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Listings Loaded", [
            'listings' => $array,
            'count' => count($array)
        ]);
    }

    public function agentRemoveListing($listing_id){
        $agent = auth()->user();
        $i = 0;
        $listing = Listing::find($listing_id);
        $listing->status == 'inactive' ? $listing->status = 'active' : $listing->status = 'inactive';
        $listing->save();

        $listings = Agent::find($agent->unique_id)->listings;

        $array = $this->formatListingData($listings, $agent);

        return $this->success('Property Removed Successfully', [
            'listings' => $array,
            'count' => count($listings)
        ]);
    }

    public function fetchListings(Request $request){
        try {
            auth()->shouldUse('tenant');
            $user = auth()->user();
            $listings  = count($request->query()) < 1 ?  $this->compileListings($user) : $this->compileListingWithQuery($request);

            $featured_listings = $this->compileFeaturedListings($user);

        }catch (Exception $e) {
            return $this->error(500, $e->getMessage()." Line:".$e->getLine());
        }
        return $this->success("Listings Loaded", [
            'listings' => $listings,
            'featured' => $featured_listings
        ]);

    }

    public function fetchPopularListings(){
        try {
            $user = auth()->user();
            $listings = $this->compilePopularListings($user);
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Popular Listings Fetched", $listings);
    }

    public function deleteListing($listing_id){
        try {
            $listing = Listing::find($listing_id) ?: throw new Exception("Listing Not Found", 404);
            Notification::where('type_id', $listing_id)->delete();

            $listing->delete();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
        return $this->success("Listing Deleted");
    }

    public function getSingleListing($username, $slug, $message = ""){
        try {
            if (!$agent = Agent::where('username', $username)->first()) { throw new Exception("This Agent Does Not Exist", 404); }
            if(!$listing = Listing::where('slug', $slug)->where('agent_id', $agent->unique_id)->first()) {throw new Exception("The Requested Listing Does Not Exist", 404);}
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $features = $this->formatListingDetails((array) json_decode($listing->features), "Feature");

        $single_listing = array_merge($listing->toArray(), [
            'features' => $features,
            'details' => json_decode($listing->details),
            'images' => json_decode($listing->images),
            'period' => $this->getDateInterval($listing->created_at)
        ]);

        $agent = Agent::find($listing->agent_id);

        return $this->success($message, [
            'listing' => $single_listing,
            'agent' => array_merge($agent->toArray(), ['avatar' => json_decode($agent->avatar)])
        ]);
    }


    public function updateListing(Request $request, $listing_id){
        try {
            $agent = auth()->user();

            $files = $request->hasFile('images') ? $this->handleFiles($request->file('images')) : [];
            $inital_fees = $request->rent + $request->extra_fees;

            $slug = $this->createDelimitedString($request->title, ' ', '-');

            Listing::find($listing_id)->update(array_merge($request->all(), [
                                            'agent_id' => $agent->unique_id,
                                            'amenities' => json_encode($request->amenities),
                                            'images' => $files,
                                            'slug' => strtolower($slug),
                                            'initial_fees' => $inital_fees ]));

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage()." :--- ".$e->getLine());
        }

        $listing = Listing::find($listing_id);
        $agent = Agent::find($listing->agent_id);

        return $this->getSingleListing($agent->username, $slug, "Your Property has been updated successfully");
    }

    public function setListingAsRented($listing_id){
        try {
            if(!$listing = Listing::find($listing_id)){ throw new Exception("Listing Not Found", 404); }

            if ($listing->rented && $listing->status = 'rented') {
                $listing->rented = false;
                $listing->status = 'active';
                $listing->save();
            }else{
                $listing->rented = true;
                $listing->status = 'rented';
                $listing->save();
            }

            $message = $listing->rented ? "Listing Set as Rented" : "Listing Set as Available";

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($message, [
            'listing' => array_merge($listing->toArray(), [
                                    'images' => json_decode($listing->images),
                                    'period' => $this->getDateInterval($listing->created_at)
                                ])
        ]);
    }

    public function suspendListing($listing_id){
        try {
            $user = auth()->user();
            if(!$listing = Listing::find($listing_id)){ throw new Exception("Listing Not Found", 404);}
            $listing->status = $listing->status === 'suspended' ? 'active' : 'suspended';
            $listing->save();
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Listing ".$listing->status, [
            'listing' => $this->formatListingData([$listing], $user)
        ]);
    }

    public function adminSuspendListing($listing_id){
        try {
            if(!$listing = Listing::find($listing_id)){ throw new Exception("Listing Not Found", 404); }

            // if ($listing->status === 'rented') {
            //     return $this->error(400, "This Property has been set as Rented");
            // }

            $listing->status = $listing->status === 'suspended' ? 'active' : 'suspended';
            $listing->save();

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $agent = Agent::find($listing->agent_id);

        return $this->getSingleListing($agent->username, $listing->slug, "Listing $listing->status");
    }

}
