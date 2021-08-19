<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller
{
    public function fetchTickets(){
        $tickets = $this->compileTicketsData();        
        return $this->view('support.tickets', 200, [
            'tickets' => $tickets
        ]);
    }

    public function compileTicketsData(){
        $tickets = Support::all();
        $array = [];
        foreach ($tickets as $key => $ticket) {
            $array[]['ticket'] = $ticket;
            $array[]['agent'] = Support::find($ticket->unique_id)->agent;
        }

        return $array;
    }

    public function markTicketAsResolved($id){
        if (!$ticket = Support::find($id)) { return $this->redirectBack('message', 'Ticket Does not Exist');}
        $ticket->status = 'resolved';
        $ticket->save();
        return $this->redirectBack('message', 'Ticket Marked As Resolved');
    }
    
    public function deleteTicket($id){
        if (!$ticket = Support::find($id)) { return $this->redirectBack('message', 'Ticket Does Not Exist');}
        $ticket->delete();
        return $this->redirectBack('message', 'Ticket Deleted Successfully');
    }

    public function singleTicket($id){
        if (!$ticket = Support::find($id)) { return $this->redirectBack('message', 'Ticket Does Not Exist');}
        $chats = Support::find($id)->chats;
        $agent = Support::find($id)->agent;
        return $this->view('support.chat', 200, [
            'ticket' => $ticket,
            'chats' => $chats,
            'agent' => $agent
        ]);
    }

    public function sendMessage(Request $request, $id){
        if (!$ticket = Support::find($id)) { return $this->redirectBack('error', 'Ticket Does Not Exist');}
        $unique_id = $this->createUniqueToken('chats', 'unique_id');
        
        $create_chat = Chat::create([
            'unqiue_id' => $unique_id,
            'agent_id' => $ticket->agent_id,
            'message' => $request->message,
            'issue_id' => $id,
            'sender' => 'Admin'
        ]);   

        if (!$create_chat) {
            return $this->redirectBack("error", "Your Reply has Not been Sent");
        }
        return $this->redirectBack("message", "Your Reply has been Sent");
    }
}
