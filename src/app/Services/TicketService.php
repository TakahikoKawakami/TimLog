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
        $newTicketEntity = $this->ticketFactory->buildFromArray($fieldsArray);
        return $this->ticketRepository->storeTicket($newTicketEntity);
    }

    public function updateTicket(int $id, array $fieldsArray): TicketEntity
    {
        $targetTicketEntity = $this->ticketRepository->getById($id, false);
        $targetTicketEntity->bulkUpdateByArray($fieldsArray);

        return $this->ticketRepository->storeTicket($targetTicketEntity);
    }

}

