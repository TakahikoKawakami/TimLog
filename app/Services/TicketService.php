<?php

namespace App\Services;
use Carbon\Carbon;
use App\Entities\TicketEntity;
use App\Factories\TicketFactoryInterface;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Repositories\TicketRepositoryInterface;

class TicketService
{
    protected $userRepository;

    protected $ticketFactory;
    protected $ticketRepository;

    public function __construct(TicketFactoryInterface $ticketFactory, TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketFactory = $ticketFactory;
        $this->ticketRepository = $ticketRepository;
    }

    public function getTickets()
    {
        return $this->ticketRepository->getTickets();
    }

    public function createTicket(array $fieldsArray): TicketEntity
    {
        $newTicket = $this->ticketFactory->buildFromArray($fieldsArray);
        return $this->ticketRepository->insertTicket($newTicket);
    }

    public function updateTicket(int $id, array $fieldsArray): TicketEntity
    {
        $arrayForUpdate = $fieldsArray;
        $arrayForUpdate['id'] = $id;
        $newlyTicketEntity = $this->ticketFactory->rebuildFromArray($fieldsArray);
        return $this->ticketRepository->insertTicket($newlyTicketEntity);
    }

}

