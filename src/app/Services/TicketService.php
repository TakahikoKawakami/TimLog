<?php

namespace App\Services;
use Carbon\Carbon;
use App\Entities\TicketEntity;
use App\Entities\TicketCollection;
use App\Factories\TicketFactoryInterface;
use App\Http\Requests\Ticket\GetTicketRequest;
use App\Repositories\TicketRepositoryInterface;
use App\Http\Requests\Ticket\CreateTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;

use Illuminate\Foundation\Application as Application; //DI利用のため
class TicketService
{
    protected $userRepository;

    protected $ticketFactory;
    protected $ticketRepository;

    public function __construct(Application $app)
    {
        $this->ticketFactory = $app->make('TicketFactory');
        $this->ticketRepository = $app->make('TicketRepository');
    }

    public function getTicketById(?array $queryArray = null)
    {
        return $this->ticketRepository->getTickets($queryArray);
    }

    public function getTickets(?array $queryArray = null): TicketCollection
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

