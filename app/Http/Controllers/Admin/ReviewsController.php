<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Reviews\CompileReviews;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    use CompileReviews;

    public function fetchReviews(){
        $reviews = Review::all();
        $data = json_decode(json_encode($this->matchReviewToListing($reviews)));
        return $this->view('reviews.reviews', 200, [
            'reviews' => $data
        ]);
    }

    public function blockReviews($id){
        if (!$review = Review::find($id)) { return $this->redirectBack('message', 'Review Does Not Exist');}
        $review->status = !$review->status;
        $review->save();
        return $this->redirectBack('message', 'Wishlist Blocked');
    }
    
    public function deleteReviews($id){
        if (!$review = Review::find($id)) { return $this->redirectBack('message', 'Review Does Not Exist');}
        $review->delete();
        return $this->redirectBack('message', 'Review Deleted Successfully');
    }
}
