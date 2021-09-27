<?php

namespace App\Http\Libraries\Notifications;

use App\Http\Libraries\Token\Token;
use App\Models\Notification;
use Exception;

trait NotificationHandler {
    use Token;

    public function makeNotification($type, $data){
        $unique_id = $this->createUniqueToken('notifications', 'unique_id');

        Notification::create([
            "unique_id" => $unique_id,
            "type" => $type,
            "type_id" => $data['type_id'],
            'receiver_id' => $data['receiver_id'],
            'publisher_id' => $data['publisher_id'],
            'message' => $data['message']
        ]);

        return true;
    }
}
