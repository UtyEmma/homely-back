<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Exception;
use Illuminate\Http\Request;

class ListingsController extends Controller
{
    public function deleteListing($id){
        if($listing = Listing::find($id)) {
            $listing->delete(); 
        }else{
            return redirect()->back()->with('message', 'Listing Does not Exist!!!');
        }
        return redirect()->back()->with('message', 'Listing Deleted!!!');
    }

    public function suspendListing($id){
        if ($listing = Listing::find($id)) {
            $listing->status = !$listing->status;
            $listing->save(); 
        }else{
            return redirect()->back()->with('message', 'Listing Does not Exist!!!');
        }
        return redirect()->back()->with('message', 'Listing Suspended!!!');
    }

    public function single($id){
        if ($listing = Listing::find($id)) {
            return view('listings.single-listing', $listing);
        }else{
            return redirect()->back()->with('message', 'Listing Does not Exist!!!');
        }
    }
}
