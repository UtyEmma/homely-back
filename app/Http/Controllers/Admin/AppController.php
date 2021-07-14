<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Category;
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
        return view('listings.listings', [
            'admin' => auth()->user(),
            'listings' => $listings
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
        return view('properties.properties', [
            'admin' => auth('web')->user(),
            'categories' => $categories
        ]);
    }
}
