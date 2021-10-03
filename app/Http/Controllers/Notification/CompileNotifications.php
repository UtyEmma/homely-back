<?php

namespace App\Http\Controllers\Notification;

use App\Models\Listing;
use App\Models\Notification;
use App\Models\Review;
use App\Models\Support;

trait CompileNotifications {

    public function compileNotifications($notifications){
        return array_map(function($notification){
            switch ($notification['type']) {
                case 'listing':
                    return $this->formatListingNotification($notification);
                case 'listing_suspended' :
                    return $this->formatListingNotification($notification);
                case 'listing_rented' :
                    return $this->formatListingNotification($notification);
                case 'listing_approved':
                    return $this->formatListingNotification($notification);
                case 'support':
                    return $this->formatSupportNotification($notification);
                case 'review':
                    return $this->formatReviewNotification($notification);
                case 'wishlist':
                    return $this->formatWishlistNotification($notification);
                default:
                    return is_array($notification) ? $notification : [];
            }
        }, $notifications->toArray());
    }

    public function formatListingNotification($notification){
        if($listing = Listing::find($notification['type_id'])){
            $notification['slug'] = $listing->slug;
            $notification['title'] = $listing->title;
            return $notification;
        }
    }

    public function formatSupportNotification($notification){
        return $notification;
    }

    public function formatReviewNotification($notification){
        if ($reviews = Review::find($notification['type_id'])) {
            $notification['rating'] = $reviews->rating;
            return $notification;
        }
    }
}
