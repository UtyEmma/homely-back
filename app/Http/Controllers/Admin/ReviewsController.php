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
            'reviews' => $data,
            'page' => 'reviews',
        ]);
    }

    public function blockReviews($id){
        if (!$review = Review::find($id)) { return $this->redirectBack('error', 'Review Does Not Exist');}
        $review->status = !$review->status;
        $review->save();
        $message = $review->status ? 'Unblocked' : 'Blocked';
        return $this->redirectBack('success', 'Review '.$message);
    }
    
    public function deleteReviews($id){
        if (!$review = Review::find($id)) { return $this->redirectBack('error', 'Review Does Not Exist');}
        $review->delete();
        return $this->redirectBack('success', 'Review Deleted Successfully');
    }
}
