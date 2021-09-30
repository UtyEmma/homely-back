<?php

namespace App\Http\Controllers\User;

use App\Models\Favourite;
use App\Models\Notification;
use App\Models\Review;
use App\Models\Wishlist;

trait CompileTenant {

    public function clearTenantData ($tenant){
        $id = $tenant->unique_id;
        Wishlist::where('user_id', $id)->delete();
        Review::where('user_id', $id)->delete();
        Favourite::where('user_id', $id)->delete();
        Notification::where('receiver_id', $id)->delete();
        $tenant->delete();
    }

}
