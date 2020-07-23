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

    public function getTickets(): TicketCollection
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
                    Carbon::parse($record->start_date_time),
                    Carbon::parse($record->stop_date_time),
                    Carbon::parse($record->deadline_date),
                    Carbon::parse($record->deadline_second),
                    $record->status,
                    $record->display_sequence
                )
            );
        }
        return new TicketCollection($ticketCollection);
    }

    // public function getById(int $id): TicketEntity
    // {
    //     // $record = $this->ticketEloquent->;
    //     // return TicketEntity::rebuild(
    //     //     $record->id,
    //     //     $record->user_id,
    //     //     $record->parent_id,
    //     //     $record->text,
    //     //     $record->memo,
    //     //     Carbon::parse($record->start_date_time),
    //     //     Carbon::parse($record->stop_date_time),
    //     //     Carbon::parse($record->deadline_date),
    //     //     Carbon::parse($record->deadline_second),
    //     //     $record->status,
    //     //     $record->display_sequence
    //     // );
    // }

    // public function store(TicketEntity $ticket): TicketEntity
    // {
    //     $storeRecord = $this->ticketEloquent->fill(
    //         $ticket->id,
    //         $ticket->user_id,
    //         $ticket->parent_id,
    //         $ticket->text,
    //         $ticket->memo,
    //         $ticket->start_date_time,
    //         $ticket->stop_date_time,
    //         $ticket->deadline_date,
    //         $ticket->deadline_second,
    //         $ticket->status,
    //         $ticket->display_sequence
    //     )->save();

    //     return
    // }

}
