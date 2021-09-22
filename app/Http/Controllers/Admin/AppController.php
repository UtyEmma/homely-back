<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Amenities;
use App\Models\Listing;
use App\Models\Review;
use App\Models\Support;
use App\Models\User;
use App\Models\Views;
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
        $pending = Support::where('status', 'pending')->limit(4)->get();
        $tickets = $this->compileTicketsData($pending);
        return view('index', [
            'admin' => auth()->user(),
            'page' => 'dashboard',
            'no_tenants' => count(User::all()),
            'no_listings' => count(Listing::all()),
            'no_agents' => count(Agent::all()),
            'reviews' => count(Review::all()),
            'categories' => count(Category::all()),
            'amenities' => count(Amenities::all()),
            'tickets' => $tickets
        ]);
    }

    public function compileTicketsData($tickets){
        $array = [];
        $i = 0;
        if (count($tickets)) {
            foreach ($tickets as $key => $ticket) {
                $item = array_merge($ticket->toArray(), ['created_at' => $this->parseTimestamp($ticket->created_at)]);
                $array[$i]['ticket'] = json_decode(json_encode($item));
                $array[$i]['agent'] = Support::find($ticket->unique_id)->agent;
                $i++;
            }
        }
        return $array;
    }

    public function tenants(){
        $tenants = User::all();
        return view('tenants.tenants', [
            'admin' => auth()->user(),
            'tenants' => $tenants,
            'page' => 'tenants',
        ]);
    }

    public function agents(){
        $agents = Agent::all();
        return view('agents.agents', [
            'admin' => auth()->user(),
            'agents' => $agents,
            'page' => 'agents',
        ]);
    }

    public function listings(){
        $listings = Listing::all();
        $array = [];
        $i = 1;

        foreach ($listings as $key => $listing) {
            $array[] = array_merge($listing->toArray(), [
                'index' => $i,
                'images' => json_decode($listing->images),
                'username' => Agent::find($listing->agent_id)->username
            ]);
            $i++;
        }

        return view('listings.listings', [
            'admin' => auth()->user(),
            'listings' => json_decode(json_encode($array)),
            'page' => 'listings',
        ]);
    }

    public function categories(){
        $categories = Category::all();
        return view('categories.categories', [
            'admin' => auth()->user(),
            'categories' => $categories,
            'page' => 'categories',
        ]);
    }

    public function profile(){
        return view('profile', [
            'admin' => auth('web')->user(),
            'page' => 'profile',
        ]);
    }


    public function properties(){
        $categories = Category::all();
        $amenities = Amenities::all();
        $features = Feature::all();
        return view('properties.properties', [
            'admin' => auth('web')->user(),
            'categories' => $categories,
            'amenities' => $amenities,
            'features' => $features,
            'page' => 'properties',
        ]);
    }

    public function admins(){
        $admins = Admin::all();
        return view('admins.admins', [
            'admins' => $admins,
            'page' => 'admins',
        ]);
    }
}
