<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('index');
    }

    public function tenants(){
        $tenants = User::all();
        return view('tenants.tenants', ['tenants' => $tenants]);
    }

    public function agents(){
        $agents = Agent::all();
        return view('agents.agents', ['agents' => $agents]);
    }

    public function listings(){
        $listings = Listing::all();
        return view('listings.listings', ['listings' => $listings]);
    }

    public function categories(){
        $categories = Category::all();
        return view('categories.categories', ['categories' => $categories]);
    }
}
