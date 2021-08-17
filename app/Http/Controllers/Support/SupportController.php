<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller{

    use CompileChats;

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

        }catch(Exception $e){
            return $this->error(500, $e->getMessage());
        }

        $array = $this->compileChats($ticket_id);
        $tickets = Support::where('agent_id', $auth->unique_id)->get();

        return $this->success("New Ticket has been Created", [
            'tickets' => $tickets,
            'chat' =>  $array
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
            throw new Exception($e->getMessage(), 500);
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
                    throw new Exception("Ticket was not creted by this Agent", 404);
                }
            }else{
                throw new Exception("Ticket Does not Exist", 404);
            }
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Ticket Deleted Successfully", );
    }

    protected function fetchAgentTickets(){
        try {
            $agent = auth()->user();
            $tickets = Support::where('agent_id', $agent->unique_id)->get();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Fetched Agents", $tickets);
    }
}
