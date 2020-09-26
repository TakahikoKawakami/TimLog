<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Entities\BaseEntity;

class TicketDisplaySequenceEntity extends BaseEntity
{
    protected $id;
    protected $ticketId;
    protected $sequence;

    public function __construct(
        ?int $id,
        int $ticketId,
        int $sequence
    )
    {
        $this->id = $id;
        $this->ticketId = $ticketId;
        $this->sequence = $sequence;
    }

    public function updateTicketId(int $value)
    {
        $this->ticketId = $value;
    }

    public function updateSequence(int $value)
    {
        $this->sequence = $value;
    }

    public function id()
    {
        return $this->id;
    }
}
