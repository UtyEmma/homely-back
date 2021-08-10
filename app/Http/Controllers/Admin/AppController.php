<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Amenities;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class AppController extends Controller
{

    public function login (){
        return view('login');
    }

    public function signup(){
        return view('register');
    }

    public function dashboard(){
        return view('index', [
            'admin' => auth()->user(),
            'no_tenants' => count(User::all()),
            'no_listings' => count(Listing::all()),
            'no_agents' => count(Agent::all())
        ]);
    }

    public function tenants(){
        $tenants = User::all();
        return view('tenants.tenants', [
            'admin' => auth()->user(),
            'tenants' => $tenants
        ]);
    }

    public function agents(){
        $agents = Agent::all();
        return view('agents.agents', [
            'admin' => auth()->user(),
            'agents' => $agents
        ]);
    }

    public function listings(){
        $listings = Listing::all();
        $array = [];
        $i = 1;

        foreach ($listings as $key => $listing) {
            $array[] = array_merge($listing->toArray(), [
                'index' => $i,
                'images' => json_decode($listing->images)
            ]);
            $i++;
        }

        return view('listings.listings', [
            'admin' => auth()->user(),
            'listings' => json_decode(json_encode($array))
        ]);
    }

    public function categories(){
        $categories = Category::all();
        return view('categories.categories', [
            'admin' => auth()->user(),
            'categories' => $categories
        ]);
    }

    public function profile(){
        return view('profile', ['admin' => auth('web')->user()]);
    }

    
    public function properties(){
        $categories = Category::all();
        $amenities = Amenities::all();
        $features = Feature::all();
        return view('properties.properties', [
            'admin' => auth('web')->user(),
            'categories' => $categories,
            'amenities' => $amenities,
            'features' => $features
        ]);
    }
}
