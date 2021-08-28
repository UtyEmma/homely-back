<?php

namespace App\Http\Controllers\Listings;

use App\Models\Listing;
use App\Models\User;
use App\Models\Agent;
use App\Models\Category;
use App\Http\Libraries\Functions\StringFunctions;

trait CompileListings{

    protected function compileListings(){
        $all = Listing::where('status', 'active')->get();
        $listings = $this->formatListingData($all);
        return $listings;
    }

    protected function compileListingWithQuery($request){
        $query = Listing::query();
        
        $query->when($request->query('state'), function($q, $state){ return $q->where('state', $state); });
        $query->when($request->query('city'), function($q, $lga){ return $q->where('city', $lga); });
        $query->when($request->query('type'), function($q, $category){ return $q->where('type', $category); });
        $query->when($request->query('price'), function($q, $income){ return $q->where('rent', $income); });

        $listing = $query->get();
        return $listing;
    }

    /** Featured Listings */
    protected function compileFeaturedListings($user){
        $user ? $user = User::find($user->unique_id) : $user = null;
        $related_listings = $this->fetchUserRelatedListings($user, 3);   
        return $this->formatListingData($related_listings);
    }

    private function fetchUserRelatedListings ($user, $index) {
        $listings = [];

        $user && $user->state ? $state = $user->state : $state =  null; 
        $user && $user->city ? $city = $user->city : $city = null;

        $state ? $by_state = Listing::where('state', $user->state)->where('status', 'active')->get() : $by_state = [];
        $city ? $by_city = Listing::where('city', $user->city)->where('status', 'active')->get() : $by_city = [];

        $related_listings = array_merge($by_state, $by_city);
        count($related_listings) < $index ? $listings = array_merge($related_listings, Listing::where('status', 'active')->get()->toArray()) : $listings = $related_listings;

        return $listings;
    }

    private function formatListingData($listings){
        $array = [];
        
        if (count($listings) > 0) {
            foreach($listings as $listing) {
                $listing = Listing::find($listing['unique_id']);

                $array[] = array_merge($listing->toArray(), [
                                'images' => json_decode($listing->images),
                                'created_at' => $this->parseTimestamp($listing->created_at)->date,
                            ]);
            }
        }
        
        return $array;
    }

    private function compilePopularListings(){
        $array = [];
        $categories = Category::all();
        $i = 0;
        if (count($categories) > 0) {
            foreach ($categories as $key => $category) {      
                $title = $category->category_title;
                             
                $category_listings = Listing::where('type', $title)->where('status', 'active')->orderBy('views', 'desc')->limit(9)->get();
                $formatted_listings = $this->formatListingData($category_listings);

                if (count($category_listings) > 0 && $i < 7) {
                    $slug = $this->createDelimitedString($title, ' ', '_');
    
                    $array[$i]['listings'] = $formatted_listings;
                    $array[$i]['category'] = [
                        'title' => $category->category_title,
                        'slug' => strtolower($slug)
                    ];   
                    $i++;
                }
            }   

        }

        return $array;
    }
}