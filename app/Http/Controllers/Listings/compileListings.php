<?php

namespace App\Http\Controllers\Listings;

use App\Models\Listing;
use App\Models\User;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;

trait CompileListings{

    protected function compileListings($user){
        $all = Listing::where('status', 'active')->get();
        $listings = $this->formatListingData($all, $user);
        return $listings;
    }

    protected function compileListingWithQuery($request){
        $query = Listing::query();
        
        $query->when($request->query('state'), function($q, $state){ return $q->where('state', $state); });
        $query->when($request->query('city'), function($q, $lga){ return $q->where('city', $lga); });
        $query->when($request->query('type'), function($q, $category){ return $q->where('type', $category); });
        $query->when($request->query('price'), function($q, $income){ 
            switch ($income) {
                case '0':
                    return $q->where('rent', "<=", 200000);
                case '1':
                    return $q->where('rent', ">=", 200000)->where('rent', "<=", 400000);
                case '2':
                    return $q->where('rent', ">=", 400000)->where('rent', "<=", 800000);
                case '3':
                    return $q->where('rent', ">=", 800000)->where('rent', "<=", 2000000);
                case '4':
                    return $q->where('rent', ">=", 2000000);
                default:
                    break;
            }
        });

        $query->when($request->query('rooms'), function($q, $rooms){ 
            switch ($rooms) {
                case '10':
                    return $q->where('no_bedrooms', '>=', $rooms );
                default:
                return $q->where('no_bedrooms', $rooms);
                    break;
            }
        });
        
        $query->when($request->query('sortby'), function ($q, $sortby){
            switch ($sortby) {
                case 'views':
                    return $q->orderBy('views', 'desc');
                case 'minprice':
                    return $q->orderBy('rent');
                case 'maxprice':
                    return $q->orderBy('rent', 'desc');
                default:
                    return $q->latest();
            }
        });

        $listing = $query->get();

        return $listing;
    }

    /** Featured Listings */
    protected function compileFeaturedListings($user){
        $user ? $user = User::find($user->unique_id) : $user = null;
        $related_listings = $this->fetchUserRelatedListings($user, 3);   
        return $this->formatListingData($related_listings, $user);
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

    public function formatListingData($listings, $user = null){
        $array = [];
        
        if (count($listings) > 0) {
            foreach($listings as $listing) {
                $listing = Listing::find($listing['unique_id']);

                $is_Favourite = false;

                if ($user) {
                    $is_Favourite = Favourite::where('user_id', $user->unique_id)->where('listing_id', $listing['unique_id'])->first();   
                }

                $array[] = array_merge($listing->toArray(), [
                                'images' => json_decode($listing->images),
                                'created_at' => $this->parseTimestamp($listing->created_at)->date,
                                'isFavourite' => $is_Favourite ? true : false,
                                'user' => $user
                            ]);
            }
        }
        
        return $array;
    }

    private function compilePopularListings($user){
        $array = [];
        $categories = Category::all();
        $i = 0;
        if (count($categories) > 0) {
            foreach ($categories as $key => $category) {      
                $title = $category->category_title;
                             
                $category_listings = Listing::where('type', $title)->where('status', 'active')->orderBy('views', 'desc')->limit(9)->get();
                $formatted_listings = $this->formatListingData($category_listings, $user);

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


    private $model;

    public function formatListingDetails($details, $model){
        $this->model = app("App\\Models\\$model");
        $array = count($details) > 0 
                ? $array = array_map(fn($key, $value) => [$this->model->where('slug', $key)->first(), 'value' => $value], 
                                array_keys($details), array_values($details)) : [];
        
        return $array;
    }
}