<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Support;
use Illuminate\Http\Request;
use Exception;

class ChatController extends Controller{
    use CompileChats;

    public function sendMessage(Request $request){
        try {
            $agent = auth()->user();
            $unique_id = $this->createUniqueToken('chats', 'unique_id');

            Chat::create([
                'message' => $request->message,
                'issue_id' => $request->issue_id,
                'sender' => 'agent',
                'unique_id' => $unique_id,
                'agent_id' => $agent->unique_id
            ]);

            $ticket = Support::find($request->issue_id);
            $ticket->no_messages = $ticket->no_messages + 1;
    
            $data = $this->compileChats($request->issue_id);
            
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Message Sent", $data);
    }

    public function fetchChats($issue_id){
        try {    
            $chats = $this->compileChats($issue_id); 
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success('', $chats);
    }
}
