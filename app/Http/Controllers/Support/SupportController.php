<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Notifications\NotificationHandler;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\Support;
use Exception;

class SupportController extends Controller{

    use CompileChats, NotificationHandler;

    public function initiateNewIssue(Request $request){
        try{
            $auth = auth()->user();
            $ticket_id = $this->createTicket($request->title, $auth->unique_id);

            if ($ticket_id){
                $unique_id = $this->createUniqueToken('chats', 'unique_id');

                Chat::create([
                    'message' => $request->message,
                    'unique_id' => $unique_id,
                    'agent_id' => $auth->unique_id,
                    'sender' => 'agent',
                    'issue_id' => $ticket_id
                ]);
            }

            $data = [
                'type_id' => $ticket_id,
                'message' => 'Your Support Ticket has been created! We will be in touch soon!',
                'publisher_id' => $auth->unique_id,
                'receiver_id' => $auth->unique_id
            ];

            $this->makeNotification('support', $data);

            $new_ticket = Support::find($ticket_id);

            $tickets =  $this->compileTickets($auth->unique_id);

        }catch(Exception $e){
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("New Ticket has been Created", [
            'tickets' => $tickets,
            'new_ticket' =>  $new_ticket
        ]);
    }

    public function createTicket($title, $agent_id){
        try {
            $unique_id = $this->createUniqueToken('supports', 'unique_id');

            Support::create([
                'title' => $title,
                'unique_id' => $unique_id,
                'agent_id' => $agent_id
            ]);

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return $unique_id;
    }

    public function deleteTicket($ticket_id){
        try {
            $agent = auth()->user();
            if($ticket = Support::find($ticket_id)){
                if ($ticket->agent_id === $agent->unique_id) {
                    $ticket->delete();
                    Chat::where('issue_id', $ticket_id)->delete();
                }else{
                    throw new Exception("Ticket was not creted by this Agent", 400);
                }
            }else{
                throw new Exception("Ticket Does not Exist", 400);
            }
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Ticket Deleted Successfully", );
    }

    protected function fetchAgentTickets(){
        try {
            $agent = auth()->user();
            $tickets = $this->compileTickets($agent->unique_id);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Fetched Agents", $tickets);
    }
}
