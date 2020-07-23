<?php

namespace App\Services;
use App\Repositories\TicketRepositoryInterface;
use App\Entities\TicketEntity;
use App\Http\Requests\TicketUpdateRequest;
use Carbon\Carbon;

class TicketService
{
    protected $userRepository;

    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getTickets()
    {
        return $this->ticketRepository->getTickets();
    }

    public function createTicket(): TicketEntity
    {
        return new TicketEntity(
            null,
            1,
            2,
            "3",
            "4",
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            9,
            10
        );
//        return $this->ticketRepository->createTicket();
    }

    public function updateTicket(int $id, TicketUpdateRequest $request): TicketEntity
    {
        $newlyTicketEntity = TicketEntity::rebuild(
            $id,
            "123",// userId
            $request->parentId,
            $request->text,
            $request->memo,
            $request->startDateTime,
            $request->stopDateTime,
            $request->deadlineDate,
            $request->deadlineSecond,
            $request->status,
            $request->displaySequence
        );
        $targetTicketEntity = $this->ticketRepository->store($newlyTicketEntity);

        return new TicketEntity(
            $id,
            1,
            2,
            "3",
            "4",
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            9,
            10
        );
//        return $this->ticketRepository->createTicket();
    }

}

