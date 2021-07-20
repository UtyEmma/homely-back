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

        $query->when($request->query('lga'), function($q, $lga){
            return $q->where('local_govt', $lga);
        });

        $query->when($request->query('category'), function($q, $category){
            return $q->where('category', $category);
        });

        $query->when($request->query('income'), function($q, $income){
            return $q->where('income', $income);
        });

        $posts = $query->get();
        return $listing;
    }
}