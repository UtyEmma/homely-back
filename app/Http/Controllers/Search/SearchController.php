<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Http\Controllers\Listings\CompileListings;

class SearchController extends Controller
{
    use CompileListings;

    public function searchListings(Request $request){
        try{
            $listings = $this->filterListings($request);

            if ($request->keyword) {
                $listings = Listing::search($request->keyword)->where('status', 'active')->get();
            }
        }catch(Exception $e){
            return $this->error(500, $e->getMessage());
        }

        return $this->success('Search Results', $listings);
    }

    private function filterListings($request){
        $listing = new Listing;
        $query = $listing->query();

        $query->when($request->query('type'), function($q, $category){
            return $q->where('type', $category);
        });

        $query->when($request->query('bedrooms'), function($q, $bedrooms){
            return $q->where('no_bedrooms', $lga);
        });

        $query->when($request->query('bathrooms'), function($q, $bathrooms){
            return $q->where('no_bathrooms', $bathrooms);
        });

        $query->when($request->query('state'), function($q, $state){
            return $q->where('state', $state);
        });

        $query->when($request->query('city'), function($q, $city){
            return $q->where('city', $city);
        });

        $query->when($request->query('areas'), function($q, $areas){
            return $q->where('areas', $areas);
        });

        $query->when($request->query('price'), function($q, $price){ 
            return $q->where('rent', $price);
        });

        $listings = $query->get();
        return $listings;
    }
}
