<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Functions\DateFunctions;
use App\Http\Controllers\Notification\CompileNotifications;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller{
    use DateFunctions, CompileNotifications;

    public function fetchNotifications(){
        $user = auth()->user();
        $all = Notification::where('receiver_id', $user->unique_id)->orderByDesc('created_at')->limit(3)->get();
        $count = count(Notification::where('receiver_id', $user->unique_id)->where('read', false)->get());

        $compiled_notifications = $this->compileNotifications($all);

        $notifications = $this->formatNotifications($compiled_notifications);
        
        return $this->success('Notifications Fetched', [
            'notifications' => $notifications,
            'no_of_notifications' => $count
        ]);
    }

    public function formatNotifications($notifications) {
        $notifications = array_map(function($notification){
            return $notification = array_merge($notification, [
                'created_at' => $this->getDateInterval($notification['created_at']) 
            ]);
        }, $notifications);

        return $notifications;
    }
}
