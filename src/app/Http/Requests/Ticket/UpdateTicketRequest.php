<?php

namespace App\Http\Requests\Ticket;

use Carbon\Carbon;
use App\Http\Requests\Base\BasePutRequest;

class UpdateTicketRequest extends BasePutRequest
{
    protected $requestBodyAvailable = [
        "parentId",
        "text",
        "memo",
        "startDateTime",
        "stopDateTime",
        "deadlineDate",
        "deadlineSecond",
        "runStartDateTime",
        "runStopDateTime",
        "runtimeSecond",
        "status",
        "displaySequence"
    ];

    public function passedValidation()
    {
        $data = $this->all();
        $data['startDateTime'] = Carbon::parse($this->input('startDateTime'));
        $data['stopDateTime'] = Carbon::parse($this->input('stopDateTime'));
        $data['deadlineDate'] = Carbon::parse($this->input('deadlineDate'));
        $data['runStartDateTime'] = Carbon::parse($this->input('runStartDateTime'));
        $data['runStopDateTime'] = Carbon::parse($this->input('runStopDateTime'));
        if (array_key_exists('memo', $data) && is_null($data['memo'])) {
            $data['memo'] = "";
        }
        $this->getInputSource()->replace($data);
    }
}
