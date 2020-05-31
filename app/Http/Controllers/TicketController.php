<?php

namespace App\Http\Controllers;

use App\Services\TicketService;

class TicketController extends Controller
{
    public function __construct() {

    }

    public function index()
    {
        $ticketService = new TicketService();
        $tickets = $ticketService->getTickets();
        return view('index-bootstrap')->with(["tickets"=>$tickets]);
    }

    public function apiIndex()
    {
        $ticketService = new TicketService();
        $tickets = $ticketService->getTickets();
        return json_decode($tickets);
    }
}
