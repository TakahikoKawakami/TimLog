<?php

namespace App\Services;
use Carbon\Carbon;
use App\Entities\TicketEntity;
use App\Factories\TicketFactoryInterface;
use App\Http\Requests\Ticket\GetTicketRequest;
use App\Http\Requests\Ticket\CreateTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
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

    public function getTickets(?array $queryArray = null)
    {
        return $this->ticketRepository->getTickets($queryArray);
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

    public function deleteTicket(int $id): bool
    {
        $targetTicketEntity = $this->ticketRepository->getById($id, false);
        $targetTicketEntity->updateStatus(TicketEntity::STATUS_DELETED);
        $this->ticketRepository->storeTicket($targetTicketEntity);

        return true;
    }

}

