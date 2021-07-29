<?php

namespace App\Http\Controllers\Listings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Listings\CreateListingRequest;
use App\Models\Agent;
use App\Models\Listing;
use Exception;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    use CompileListings;

    public function createListing(CreateListingRequest $request){
        // try {
            $agent = $this->agent();
            
            $files = []; 
            $request->hasFile('images') && $files = $this->handleFiles($request->file('images'));
    
            $listing_id = $this->createUniqueToken('listings', 'unique_id');


            $slug = $this->createDelimitedString($request->title, ' ', '-');

            Listing::create(array_merge($request->all(), [
                                        'unique_id' => $listing_id,
                                        'agent_id' => $agent->unique_id,
                                        'details' => $request->details,
                                        'features' => $request->features,
                                        'images' => $files,
                                        'slug' => $slug
                                        ]));
        // } catch (Exception $e) {
        //     return $this->error(500, $e->getMessage()." :--- ".$e->getLine());
        // }

        $agent = Agent::find($agent->unique_id);
        $agent->no_of_listings = $agent->no_of_listings + 1;
        $agent->save();

        return $this->success("Listing has been added Successfully");
    }

    // Get a User's Listings
    public function getAgentsListings(){
        try {
            $agent = $this->agent();
            $array = [];
            $listings = Agent::find($agent->unique_id)->listings;
            $i = 0;
            
            if (count($listings) > 0) {
                foreach ($listings as $listing) {
                    $array[$i] = array_merge($listing->toArray(), [
                                    'images' => json_decode($listing->images),
                                    'features' => json_decode($listing->features),
                                    'details' => json_decode($listing->details) 
                                ]);
                    $i++;
                }
            }else{
                $array = null;
            }

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Listings Loaded", $array);
    }

    public function fetchAll (Request $request){
        try {
            $array = [];
            
            count($request->query()) < 1 
                    ? $listings = Listing::all() 
                        : $listings = $this->compileListingWithQuery($request);
            
            if (count($listings) > 0) {
                $i = 0;
                foreach($listings as $listing) {
                    $array[$i] = array_merge($listing->toArray(), [
                                    'images' => json_decode($listing->images),
                                    'features' => json_decode($listing->features),
                                    'details' => json_decode($listing->details),
                                ]);
                    $i++;
                }
            }

        }catch (Exception $e) {
            return $this->error(500, $e->getMessage()." Code:".$e->getCode());
        }

        return $this->success("Listings Loaded", [
            'listings' => $array,
            'count' => count($array)
        ]);
        
    }

    public function getActiveListings(){
        try {
            $i = 0;
            $array = [];
            $active_listings = Listing::all();

            if (count($active_listings) > 0) {
                foreach ($active_listings as $listing) {
                    $array[$i] = array_merge($listing->toArray(), [
                                    'images' => json_decode($listing->images),
                                    'features' => json_decode($listing->features),
                                    'details' => json_decode($listing->details),
                                ]);
                    $i++;
                }
            }else{
                $array = null;
            }

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Active Listings Loaded", [
            'listings' => $array,
            'count' => count($array)
        ]);
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
    public function getSingleListing($slug){
        try {
            $listing = Listing::where('slug', $slug)->first();
            if (!$listing) {
                throw new Exception("The Requested Listing Does Not Exist", 500);
            } 
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $single_listing = array_merge($listing->toArray(), [
            'features' => json_decode($listing->features),
            'details' => json_decode($listing->details),
            'images' => json_decode($listing->images)
        ]);

        return $this->success("Listing Loaded", $single_listing);
    }

}
