<?php

namespace App\Repositories;

use App\Model\Ticket;
use App\Entities\TicketCollection;
use App\Entities\TicketEntity;

interface TicketRepositoryInterface
{
    const STATUS_NEW = 0;
    const STATUS_STARTED = 1;
    const STATUS_STOPPED = 2;
    const STATUS_FINISHED = 3;
    const STATUS_DELETED = 99;

    public function getTickets(array $queryArray, bool $getFinished, bool $getDeleted): TicketCollection;

    public function getById(int $id, bool $getDeleted): ?TicketEntity;

    public function storeTicket(TicketEntity $ticket): ?TicketEntity;


}
