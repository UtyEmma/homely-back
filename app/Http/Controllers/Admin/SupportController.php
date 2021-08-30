<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Notifications\NotificationHandler;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller{
    use NotificationHandler;

    public function fetchTickets(){
        $tickets = $this->compileTicketsData();    
        return $this->view('support.tickets', 200, [
            'tickets' => $tickets
        ]);
    }

    public function compileTicketsData(){
        $tickets = Support::all();
        $array = [];
        $i = 0;
        foreach ($tickets as $key => $ticket) {
            $array[$i]['ticket'] = Support::find($ticket->unique_id);
            $array[$i]['agent'] = Support::find($ticket->unique_id)->agent;
            $i++;
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

    public function sendMessage(Request $request, $ticket_id){
        if (!$ticket = Support::find($ticket_id)) { return $this->redirectBack('error', 'Ticket Does Not Exist');}

        $unique_id = $this->createUniqueToken('chats', 'unique_id');

        $create_chat = Chat::create([
            'unique_id' => $unique_id,
            'agent_id' => $ticket->agent_id,
            'message' => $request->message,
            'issue_id' => $ticket_id,
            'sender' => 'Admin'
        ]);   

        if (!$create_chat) {
            return $this->redirectBack("error", "Your Reply has Not been Sent");
        }

        $admin = auth()->user();

        $data = [
            'type_id' => $ticket_id,
            'message' => "You have a new message from Homly Support",
            'receiver_id' => $ticket->agent_id,
            'publisher_id' => $admin->unique_id,
        ];

        $this->makeNotification('support', $data);

        return $this->redirectBack("success", "Your Reply has been Sent");
    }
}
