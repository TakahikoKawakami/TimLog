<?php

namespace App\Http\Requests\TicketDisplaySequence;

use Carbon\Carbon;
use App\Http\Requests\Base\BasePutRequest;

class UpdateTicketDisplaySequenceRequest extends BasePutRequest
{
    protected $requestBodyAvailable = [
        'sortArray',
    ];
}
