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

    private function __construct(
        ?int $id,
        int $userId,
        int $parentId,
        string $text,
        string $memo,
        Carbon $startDateTime,
        Carbon $stopDateTime,
        Carbon $deadlineDate,
        Carbon $deadlineSecond,
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

    public static function build(
        int $userId,
        int $parentId,
        string $text,
        string $memo,
        Carbon $startDateTime,
        Carbon $stopDateTime,
        Carbon $deadlineDate,
        Carbon $deadlineSecond,
        int $status,
        int $displaySequence
    ): TicketEntity
    {
        return new TicketEntity(
            null,
            $userId,
            $parentId,
            $text,
            $memo,
            $startDateTime,
            $stopDateTime,
            $deadlineDate,
            $deadlineSecond,
            $status,
            $displaySequence
        );
    }

    public static function rebuild(
        int $id,
        int $userId,
        int $parentId,
        string $text,
        string $memo,
        Carbon $startDateTime,
        Carbon $stopDateTime,
        Carbon $deadlineDate,
        Carbon $deadlineSecond,
        int $status,
        int $displaySequence
    ): TicketEntity
    {
        return new TicketEntity(
            $id,
            $userId,
            $parentId,
            $text,
            $memo,
            $startDateTime,
            $stopDateTime,
            $deadlineDate,
            $deadlineSecond,
            $status,
            $displaySequence
        );
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
