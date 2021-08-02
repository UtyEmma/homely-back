<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;

class SearchController extends Controller
{
    public function search(Request $request){
        $query = Listing::query();
        $query->when($request->query('category'), function($q, $category){
            return $q->where('category', $category);
        });

        $query->when($request->query('bedrooms'), function($q, $bedrooms){
            return $q->where('bedrooms', $lga);
        });

        $query->when($request->query('bathrooms'), function($q, $bathrooms){
            return $q->where('bathrooms', $bathrooms);
        });

        $query->when($request->query('city'), function($q, $city){
            return $q->where('city', $city);
        });

        $query->when($request->query('areas'), function($q, $areas){
            return $q->where('areas', $areas);
        });
        
        $query->when($request->query('keyword'), function($q, $keyword){
            return $q->where('title', $keyword);
        });

        $listings = $query->get();
        return $listings;
    }
}