<?php

namespace App\Http\Requests\Ticket;

use Carbon\Carbon;
use App\Http\Requests\Base\BasePutRequest;

class UpdateTicketRequest extends BasePutRequest
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
        $data['start_date_time'] = Carbon::parse($this->input('start_date_time'));
        $data['stop_date_time'] = Carbon::parse($this->input('stop_date_time'));
        $data['deadline_date'] = Carbon::parse($this->input('deadline_date'));
        $data['run_start_date_time'] = Carbon::parse($this->input('run_start_date_time'));
        $data['run_stop_date_time'] = Carbon::parse($this->input('run_stop_date_time'));
        if (array_key_exists('memo', $data) && is_null($data['memo'])) {
            $data['memo'] = "";
        }
        $this->getInputSource()->replace($data);
    }
}
