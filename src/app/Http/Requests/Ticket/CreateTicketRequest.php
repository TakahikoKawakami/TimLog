<?php

namespace App\Http\Requests\Ticket;

use App\Http\Requests\Base\BasePostRequest;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreateTicketRequest extends BasePostRequest
{
    protected $requestBodyAvailable = [
        "parent_id",
        "text",
        "memo",
        "start_date_time",
        "stop_date_time",
        "deadline_date",
        "deadline_second",
        "run_start_date_time",
        "run_stop_date_time",
        "runtime_second",
        "status",
        "display_sequence"
    ];

    public function passedValidation()
    {
        $data = $this->all();
        $data['startDateTime'] = Carbon::parse($this->input('start_date_time'));
        $data['stopDateTime'] = Carbon::parse($this->input('stop_date_time'));
        $data['deadlineDate'] = Carbon::parse($this->input('deadline_date'));
        $data['runStartDateTime'] = Carbon::parse($this->input('run_start_date_time'));
        $data['runStopDateTime'] = Carbon::parse($this->input('run_stop_date_time'));
        if (array_key_exists('memo', $data) && is_null($data['memo'])) {
            $data['memo'] = "";
        }
        $this->getInputSource()->replace($data);
    }
}
