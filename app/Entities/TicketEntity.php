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
    protected $deadlineDateTIme;
    protected $status;

    private function __construct(
        ?int $id, 
        int $userId, 
        int $parentId, 
        string $text, 
        string $memo, 
        Carbon $startDateTime, 
        Carbon $stopDateTime,
        Carbon $deadlineDateTime,
        int $status
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->parentId = $parentId;
        $this->text = $text;
        $this->memo = $memo;
        $this->startDateTime = $startDateTime;
        $this->stopDateTime = $stopDateTime;
        $this->deadlineDateTIme = $deadlineDateTime;
        $this->status = $status;
    }

    public static function build(
        int $userId, 
        int $parentId, 
        string $text, 
        string $memo, 
        Carbon $startDateTime, 
        Carbon $stopDateTime,
        Carbon $deadlineDateTime,
        int $status
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
            $deadlineDateTime,
            $status
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
        Carbon $deadlineDateTime,
        int $status
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
            $deadlineDateTime,
            $status
        );
    }
}
