<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function fetchWishlists(){
        $wishlists = Wishlist::all();
        return $this->view('wishlists.wishlists', 200, [
            'wishlists' => $wishlists,
            'page' => 'wishlists'
        ]);
    }

    public function blockWishlists($id){
        if (!$wishlist = Wishlist::find($id)) { return $this->redirectBack('error', 'Wishlist Does Not Exist');}
        $wishlist->status = !$wishlist->status;
        $wishlist->save();
        return $this->redirectBack('success', 'Wishlist Blocked');
    }
    
    public function deleteWishlists($id){
        if (!$wishlist = Wishlist::find($id)) { return $this->redirectBack('error', 'Wishlist Does Not Exist');}
        $wishlist->delete();
        return $this->redirectBack('success', 'Wishlist Deleted Successfully');
    }
}
