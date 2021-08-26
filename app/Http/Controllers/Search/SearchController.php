<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Http\Controllers\Listings\CompileListings;
use Exception;

class SearchController extends Controller{
    use CompileListings;

    public function searchListings(Request $request){
        try{
            $listings = Listing::search($request->keyword)->where('status','active')->get();

            $query = collect($listings);

            $query->when($request->type, function($q, $type){ 
                return $q->where('type', $type); 
            });

            $query->when($request->state, function($q, $state){ 
                return $q->where('state', $state); 
            });

            $query->when($request->city, function($q, $city){ 
                return $q->where('city', $city); 
            });

            $query->when($request->price, function($q, $income){ 
                return $q->where('rent', $income); 
            });

            $query->when($request->bedrooms, function($q, $bedrooms){ 
                return $q->where('no_bedrooms', $bedrooms); 
            });

            $query->when($request->bathrooms, function($q, $bathrooms){ 
                return $q->where('no_bathrooms', $bathrooms); 
            });

            $listings = $this->formatListingData($query);
        
        }catch(Exception $e){
            return $this->error(500, $e->getMessage());
        }

        return $this->success('Search Results', $listings);
    }

}
