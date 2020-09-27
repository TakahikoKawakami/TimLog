<?php
namespace App\Factories;
use Carbon\Carbon;
use App\Entities\TicketEntity;

use App\Factories\TicketFactoryInterface;
use App\Entities\TicketDisplaySequenceEntity;



class TicketDisplaySequenceFactory implements TicketDisplaySequenceFactoryInterface
{

    public function build(
        int $id,
        int $ticketId,
        int $sequence
    ): TicketDisplaySequenceEntity
    {
        return $this->rebuild(
            null,
            $ticketId,
            $sequence,
        );
    }

    public function rebuild(
        ?int $id,
        int $ticketId,
        int $sequence
    ): TicketDisplaySequenceEntity
    {
        return new TicketDisplaySequenceEntity(
            $id,
            $ticketId,
            $sequence
        );
    }

    public function buildFromArray(array $array): TicketDisplaySequenceEntity
    {
        $rebuildArray = $array;
        $rebuildArray['id'] = null;
        return $this->rebuildFromArray($rebuildArray);
    }

    public function rebuildFromArray(array $array): TicketDisplaySequenceEntity
    {
        return $this->rebuild(
            $array['id'],
            $array['ticket_id'],
            $array['sequence'],
        );
    }

    public function rebuildFromEloquent($eloquent): TicketDisplaySequenceEntity
    {
        return $this->rebuild(
            $eloquent->id,
            $eloquent->ticket_id,
            $eloquent->sequence,
        );
    }
}
