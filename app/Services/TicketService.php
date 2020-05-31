<?php

namespace App\Services;
use App\Repositories\TicketRepository;

class TicketService
{
    public function __construct()
    {
    }

    public function getTickets()
    {
        $ticketRepository = new TicketRepository();
        return $ticketRepository->getTickets();

    }
}

