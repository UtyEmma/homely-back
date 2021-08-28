<?php

namespace App\Http\Controllers\Listings;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Notifications\NotificationHandler;
use App\Http\Requests\Listings\CreateListingRequest;
use App\Models\Agent;
use App\Models\Listing;
use Exception;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    use CompileListings, NotificationHandler;

    public function createListing(CreateListingRequest $request){
        try {
            $agent = auth()->user();
            $files = []; 

            $request->hasFile('images') && $files = $this->handleFiles($request->file('images'));
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
            'message' => 'Your Listing has been submitted and is being reviewed',
            'publisher_id' => $agent->unique_id,
            'receiver_id' => $agent->unique_id,
        ];

        $this->makeNotification('listing', $listing);

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
        $array = [];
        $i = 0;
        $listing = Listing::find($listing_id);
        $listing->status == 'inactive' ? $listing->status = 'active' : $listing->status = 'inactive';
        $listing->save();

        $listings = Agent::find($agent->unique_id)->listings;

        $array = $this->formatListingData($listings);

        return $this->success('Property Removed Successfully', [
            'listings' => $array,
            'count' => count($listings)
        ]);
    }

    public function fetchListings(Request $request){
        try {
            $user = auth()->user();

            count($request->query()) < 1 
                    ? $listings = $this->compileListings() 
                        : $listings = $this->compileListingWithQuery($request);

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
            $listings = $this->compilePopularListings();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Popular Listings Fetched", $listings);
    }

    public function deleteListing($listing_id){
        try { 
            $listing = Listing::find($listing_id);
            $listing->delete();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
        return $this->success("Listing Deleted");   
    }

    public function getSingleListing($slug){
        try {
            $listing = Listing::where('slug', $slug)->first();
            if (!$listing) {
                throw new Exception("The Requested Listing Does Not Exist", 500);
            } 
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $details = $this->formatListingDetails((array) json_decode($listing->details), "Amenities");
        $features = $this->formatListingDetails((array) json_decode($listing->features), "Feature");

        $single_listing = array_merge($listing->toArray(), [
            'features' => $features,
            'details' => json_decode($listing->details),
            'images' => json_decode($listing->images),
            'period' => str_replace("before","ago", $this->getDateInterval($listing->created_at))
        ]);

        $agent = Agent::find($listing->agent_id);

        return $this->success("Listing Loaded", [
            'listing' => $single_listing,
            'agent' => array_merge($agent->toArray(), ['avatar' => json_decode($agent->avatar)])
        ]);
    }

    public function formatListingDetails($details, $model){
        $array = [];
        $model = app("App\\Models\\$model");
        if (count($details) > 0) {
            foreach ($details as $key => $value) {
                $array[] = [$model->where('slug', $key)->first(), 'value' => $value];
            }
        } 
        return $array;
    }

    public function updateListing(Request $request, $listing_id){
        
    }

    public function setListingAsRented($listing_id){
        try {
            if (!$listing = Listing::find($listing_id)) { throw new Exception("Listing Not Found", 404); }
            $listing->rented = true;
            $listing->status = 'rented';
            $listing->save();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Listing Set as Rented", [
            'listing' => $listing
        ]);
    }
}
