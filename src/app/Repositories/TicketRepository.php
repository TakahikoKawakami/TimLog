<?php

namespace App\Repositories;
use Carbon\Carbon;

use App\Model\Ticket;
use Illuminate\Support\Str;
use App\Entities\TicketEntity;
use App\Entities\TicketCollection;
use App\Factories\TicketFactoryInterface;
use App\Repositories\TicketRepositoryInterface;

class TicketRepository implements TicketRepositoryInterface
{
    protected $ticketEloquent;

    public function __construct(TicketFactoryInterface $ticketFactory)
    {
        $this->ticketFactory = $ticketFactory;
        $this->ticketEloquent = new Ticket();
    }

    public function getTickets(): TicketCollection
    {
        $records = $this->ticketEloquent->get();

        $ticketCollection = collect();
        foreach ($records as $record) {
            $ticketCollection->push(
                $this->ticketFactory->rebuild(
                    $record->id,
                    $record->user_id,
                    $record->parent_id,
                    $record->text,
                    $record->memo,
                    Carbon::parse($record->start_date_time),
                    Carbon::parse($record->stop_date_time),
                    Carbon::parse($record->deadline_date),
                    $record->deadline_second,
                    $record->status,
                    $record->display_sequence
                )
            );
        }
        return new TicketCollection($ticketCollection);
    }

    public function getById(int $id, bool $getDeleted = false): TicketEntity
    {
        $eloquent = $this->ticketEloquent->where('id', $id);
        if (!$getDeleted) {
            $eloquent = $eloquent->where('status','!=', self::STATUS_DELETED);
        }
        $record = $eloquent->first();
        return $this->ticketFactory->rebuildFromEloquent($record);
    }

    public function storeTicket(TicketEntity $ticket): TicketEntity
    {
        $request = $ticket->toArray();

        // insert時、idにはnullが入っているので、削除する
        if (is_null($request['id'])) {
            unset($request['id']);
        }
        return $this->store($request);
    }

    // public function storeTicket(TicketEntity $ticket): TicketEntity
    // {
    //     $request = $ticket->toArray();
    //     foreach ($request as $key => $value) {
    //         $this->ticket->$key = $value;
    //     }
    //     $developerPaymentHead->update();
    //     return $this->getByPrimary($developerPaymentHead->id);

    //     $storeRecord = $this->ticketEloquent->fill(
    //     )->save();

    //     return
    // }

    private function store(array $request): TicketEntity
    {
        $fillArray = [];
        foreach ($request as $key => $value) {
            $fillArray[Str::snake($key)] = $value;
        }
        $this->ticketEloquent->fill($fillArray)->save();

        return $this->getById($this->ticketEloquent->id, false);
    }
}
