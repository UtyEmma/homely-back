<?php

namespace App\Http\Controllers\Support;

use App\Http\Libraries\Functions\DateFunctions;
use App\Models\Support;
use Exception;

trait CompileChats{
    use DateFunctions;

    protected function compileChats($ticket_id){
        if (!$ticket = Support::find($ticket_id)) {
            throw new Exception("Ticket Not Found", 404);
        }

        $chat_data = Support::find($ticket_id)->chats;
        $chats = $this->formatChats($chat_data);

        $dt = $this->parseTimestamp($ticket->created_at);
        $ticket_data = array_merge($ticket->toArray(), ['date' => $dt->date, 'time' => $dt->time ]);

        return [
            'ticket' => $ticket_data,
            'chats' => $chats
        ];
    }

    public function  compileTickets($agent_id){
        $tickets = Support::where('agent_id', $agent_id)->get();
        $array = [];

        foreach ($tickets as $key => $ticket) {
            $dt = $this->parseTimestamp($ticket->created_at);
            $array[] = array_merge($ticket->toArray(), ['date' => $dt->date, 'time' => $dt->time]);
        }

        return $array;
    }

    private function formatChats($chats){
        $array = [];
        if (count($chats) > 0) {
            foreach ($chats as $key => $chat) {
                $dt = $this->parseTimestamp($chat->created_at);
                $array[] = array_merge($chat->toArray(), ['date' => $dt->date, 'time' => $dt->time]);
            }
        }

        return $array;
    }

}
