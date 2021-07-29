<?php

namespace App\Http\Controllers\Listings;

use App\Models\Listing;
use App\Models\User;

trait CompileListings{

    protected function compileListings(){
        $auth = auth()->user();
        $user = User::find($auth->unique_id);
    }

    protected function compileListingWithQuery($request){
        $query = Listing::query();
        
        $query->when($request->query('state'), function($q, $state){
            return $q->where('state', $state);
        });

        $query->when($request->query('city'), function($q, $lga){
            return $q->where('city', $lga);
        });

        $query->when($request->query('type'), function($q, $category){
            return $q->where('type', $category);
        });

        $query->when($request->query('price'), function($q, $income){
            return $q->where('initial_price', $income);
        });

        $listing = $query->get();
        return $listing;
    }
}