<?php

namespace App\Http\Libraries\Notifications;

use App\Http\Libraries\Token\Token;
use App\Models\Notification;
use Exception;

trait NotificationHandler {
    use Token;

    public function makeNotification($type, $data){     
        switch ($type) {
            case 'listing':
                return $this->handleListing($data, $type);
            case 'support':
                return $this->handleSupport($data, $type);
            case 'review':
                return $this->handleReviews($data, $type);
            case 'chat':
                return $this->handleChat($data, $type);
                break;
            default:
                return false;
        }
    }


    private function handleListing($data, $type){
         $unique_id = $this->createUniqueToken('notifications', 'unique_id');

        Notification::create([
            "unique_id" => $unique_id,
            "type" => $type,
            "type_id" => $data['type_id'],
            'receiver_id' => $data['receiver_id'],
            'publisher_id' => $data['publisher_id'],
            'message' => $data['message']
        ]);

        // $this->sendNotificationEmail();

        return true;
    }

    private function handleSupport($data, $type){
        $unique_id = $this->createUniqueToken('notifications', 'unique_id');

        Notification::create([
            "unique_id" => $unique_id,
            "type" => $type,
            "type_id" => $data['type_id'],
            'receiver_id' => $data['receiver_id'],
            'publisher_id' => $data['publisher_id'],
            'message' => $data['message']
        ]);

        // $this->sendNotificationEmail();

        return true;
    }

    private function handleReviews($data, $type){
        $unique_id = $this->createUniqueToken('notifications', 'unique_id');

        Notification::create([
            "unique_id" => $unique_id,
            "type" => $type,
            "type_id" => $data['type_id'],
            'receiver_id' => $data['receiver_id'],
            'publisher_id' => $data['publisher_id'],
            'message' => $data['message']
        ]);

        // $this->sendNotificationEmail();

        return true;
    }

    private function handleChat($data, $type){

    }

}