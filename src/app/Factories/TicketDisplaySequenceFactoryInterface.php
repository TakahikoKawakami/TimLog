<?php
namespace App\Factories;
use Carbon\Carbon;

use App\Entities\TicketEntity;
use App\Entities\TicketDisplaySequenceEntity;

interface TicketDisplaySequenceFactoryInterface
{
    public function build(
        int $id,
        int $ticketId,
        int $sequence
    ): TicketDisplaySequenceEntity;

    public function rebuild(
        ?int $id,
        int $ticketId,
        int $sequence
    ): TicketDisplaySequenceEntity;

    public function buildFromArray(array $array): TicketDisplaySequenceEntity;

    public function rebuildFromArray(array $array): TicketDisplaySequenceEntity;

    public function rebuildFromEloquent($eloquent): TicketDisplaySequenceEntity;

}
