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
            try {
                $listing->delete();
            } catch (Exception $e) {
                return redirect()->back()->with('message', $e->getMessage());                
            }   

            return redirect()->back()->with('message', 'Listing Deleted!!!');
        }else{
            return redirect()->back()->with('message', 'Listing Does not Exist!!!');
        }
    }

    public function suspendListing($id){
        if ($listing = Listing::find($id)) {
            try {
                $listing->status = false;
                $listing->save();
            } catch (Exception $e) {
                return redirect()->back()->with('message', $e->getMessage());                
            }   

            return redirect()->back()->with('message', 'Listing Suspended!!!');
        }else{
            return redirect()->back()->with('message', 'Listing Does not Exist!!!');
        }
    }

    public function single($id){
        if ($listing = Listing::find($id)) {
            return view('listings.single-listing', $listing);
        }else{
            return redirect()->back()->with('message', 'Listing Does not Exist!!!');
        }
    }
}
