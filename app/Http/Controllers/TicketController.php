<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepositoryInterface;
use App\Services\TicketService;

class TicketController extends Controller
{
    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        $ticketService = new TicketService($this->ticketRepository);
        $tickets = $ticketService->getTickets();
        return view('index-bootstrap')->with(["tickets"=>$tickets]);
    }

    public function apiIndex()
    {
        $ticketService = new TicketService($this->ticketRepository);
        $tickets = $ticketService->getTickets();
        $tickets = $tickets->toArray();
        return json_encode($tickets);
    }
}
