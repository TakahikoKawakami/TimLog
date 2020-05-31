<?php

namespace App\Repositories;

use App\Model\Ticket;

class TicketRepository
{
    public function __construct()
    {
    }

    public function getTickets()
    {
        $ticketsModel = new Ticket();
        return $ticketsModel->get();
    }

}
