<?php

namespace App\Http\Requests\TicketDisplaySequence;

use App\Http\Requests\Base\BasePostRequest;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreateTicketDisplaySequenceRequest extends BasePostRequest
{
    protected $requestBodyAvailable = [
        "ticket_id",
        "sequence"
    ];
}
