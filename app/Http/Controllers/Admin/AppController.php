<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Utils\CompileItems;
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
use Cloudinary\Transformation\IfElse;
use Illuminate\Http\Request;

class AppController extends Controller{
    use CompileItems;

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

    public function tenants(Request $request){
        if ($request->has('sort')) {
            $tenants = $this->sortTenants($request);
        }else if($request->has('search')){
            $tenants = User::where($request->search_param, $request->query('search'))->paginate(5);
        }else{
            $tenants = User::paginate(15);
        }

        return view('tenants.tenants', [
            'admin' => auth()->user(),
            'tenants' => $tenants,
            'page' => 'tenants',
        ]);
    }

    public function agents(Request $request){
        if ($request->has('sort')) {
            $agents = $this->sortAgents($request);
        }else if($request->has('search')){
            $agents = Agent::where($request->search, $request->query('search'))->paginate(5);
        }else{
            $agents = Agent::paginate(15);
        }

        return view('agents.agents', [
            'admin' => auth()->user(),
            'agents' => $agents,
            'page' => 'agents',
        ]);
    }

    public function listings(Request $request){
        if ($request->has('sort')) {
            $listings = $this->sortListings($request);
        }else if($request->has('search')){
            $listings = Listing::where('title', $request->query('search'))->paginate(5);
        }else{
            $listings = Listing::paginate(15);
        }

        // $array = [];

        // foreach ($listings as $key => $listing) {
        //     $agent = Agent::find($listing->agent_id);
        //     $array[] = [
        //         'images' => json_decode($listing->images),
        //         'username' => $agent->username
        //     ];
        // }

        return view('listings.listings', [
            'admin' => auth()->user(),
            'listings' => $listings,
            // 'agent' => $array,
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
        $categories = Category::paginate(6);
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
