<?php

namespace App\Repositories;

use App\Model\Ticket;
use App\Entities\TicketCollection;
use App\Entities\TicketEntity;

interface TicketRepositoryInterface
{
    public function getTickets();

    // public function getById();

    // public function store();

}
