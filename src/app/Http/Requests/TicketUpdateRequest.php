<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Http\Requests\BasePutRequest;

class TicketUpdateRequest extends BasePutRequest
{
    protected $requestBodyAvailable = [
        "parentId",
        "text",
        "memo",
        "startDateTime",
        "stopDateTime",
        "deadlineDate",
        "deadlineSecond",
        "status",
        "displaySequence"
    ];

    public function passedValidation()
    {
        $data = $this->all();
        $data['startDateTime'] = Carbon::parse($this->input('startDateTime'));
        $data['stopDateTime'] = Carbon::parse($this->input('stopDateTime'));
        $data['deadlineDate'] = Carbon::parse($this->input('deadlineDate'));
        if (array_key_exists('memo', $data) && is_null($data['memo'])) {
            $data['memo'] = "";
        }
        $this->getInputSource()->replace($data);
    }
}
