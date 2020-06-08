<?php

namespace App\Services;
use App\Repositories\TicketRepositoryInterface;

class TicketService
{
    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getTickets()
    {
        return $this->ticketRepository->getTickets();
    }
}

