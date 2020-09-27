<?php

namespace App\Model;
use App\Model\Ticket;

use Illuminate\Database\Eloquent\Model;

class TicketDisplaySequence extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'ticket_id',
        'sequence',
    ];

    public function ticket()
    {
        return $this->hasOne('App\Model\Ticket', 'ticket_id', 'id');
    }
}
