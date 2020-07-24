<?php

namespace App\Entities;

use Carbon\Carbon;

class TicketEntity
{
    protected $id;
    protected $userId;
    protected $parentId;
    protected $text;
    protected $memo;
    protected $startDateTime;
    protected $stopDateTime;
    protected $deadlineDate;
    protected $deadlineSecond;
    protected $status;
    protected $displaySequence;

    public function __construct(
        ?int $id,
        int $userId,
        int $parentId,
        string $text,
        string $memo,
        Carbon $startDateTime,
        Carbon $stopDateTime,
        Carbon $deadlineDate,
        int $deadlineSecond,
        int $status,
        int $displaySequence
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->parentId = $parentId;
        $this->text = $text;
        $this->memo = $memo;
        $this->startDateTime = $startDateTime;
        $this->stopDateTime = $stopDateTime;
        $this->deadlineDate = $deadlineDate;
        $this->deadlineSecond = $deadlineSecond;
        $this->status = $status;
        $this->displaySequence = $displaySequence;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'parentId' => $this->parentId,
            'text' => $this->text,
            'memo' => $this->memo,
            'startDateTime' => $this->startDateTime,
            'stopDateTime' => $this->stopDateTime,
            'deadlineDate' => $this->deadlineDate,
            'deadlineSecond' => $this->deadlineSecond,
            'status' => $this->status,
            'displaySequence' => $this->displaySequence,
        ];
    }


}
