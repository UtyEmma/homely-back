<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;

class SearchController extends Controller
{
    public function searchListings(Request $request){
        
        $query = Listing::query();
        try{
            $listings = Listing::search($request->keyword)->get();
        }catch(Exception $e){
            return $this->error(500, $e->getMessage());
        }
        // $query->when($request->query('keyword'), function($q, $keyword){
        //     return $q->query('keyword', '/%$keyword%/');
        // });

        // $query->when($request->query('category'), function($q, $category){
        //     return $q->where('category', $category);
        // });

        // $query->when($request->query('bedrooms'), function($q, $bedrooms){
        //     return $q->where('bedrooms', $lga);
        // });

        // $query->when($request->query('bathrooms'), function($q, $bathrooms){
        //     return $q->where('bathrooms', $bathrooms);
        // });

        // $query->when($request->query('city'), function($q, $city){
        //     return $q->where('city', $city);
        // });

        // $query->when($request->query('areas'), function($q, $areas){
        //     return $q->where('areas', $areas);
        // });
        
        // $query->when($request->query('keyword'), function($q, $keyword){
        //     return $q->where('title', $keyword);
        // });

        // $query->when($request->query('price'), function($q, $price){
        //     return $q->where('rent', $price);
        // });

        // $listings = $query->get();
        return $listings;
    }

    private function filterSearchResults($results, $request){
        $array = [];
        
        foreach ($results as $key => $result) {
            
        }
    }
}
