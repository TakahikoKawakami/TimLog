<?php

namespace App\Repositories;
use Carbon\Carbon;

use App\Repositories\TicketRepositoryInterface;
use App\Model\Ticket;
use App\Entities\TicketCollection;
use App\Entities\TicketEntity;

class TicketRepository implements TicketRepositoryInterface
{
    protected $ticketEloquent;

    public function __construct()
    {
        $this->ticketEloquent = new Ticket();
    }

    public function getTickets() 
    {
        $records = $this->ticketEloquent->get();
//        return $records;

        $ticketCollection = collect();
        foreach ($records as $record) {
            $ticketCollection->push(
                TicketEntity::rebuild(
                    $record->id,
                    $record->user_id,
                    $record->parent_id,
                    $record->text,
                    $record->memo,
                    Carbon::parse($record->start_date),
                    Carbon::parse($record->stop_date),
                    Carbon::parse($record->deadline_date),
                    $record->status
                )
            );
        }
        return new TicketCollection($ticketCollection);
    }

}
