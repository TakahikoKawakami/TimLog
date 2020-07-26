<?php
namespace App\Factories;
use App\Entities\TicketEntity;
use App\Factories\TicketFactoryInterface;

use Carbon\Carbon;



class TicketFactory implements TicketFactoryInterface
{

    public function build(
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
    ): TicketEntity
    {
        return $this->rebuild(
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

    public function rebuild(
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

    public function buildFromArray(array $array): TicketEntity
    {
        $rebuildArray = $array;
        $rebuildArray['id'] = null;
        return $this->rebuildFromArray($rebuildArray);
    }

    public function rebuildFromArray(array $array): TicketEntity
    {
        return $this->rebuild(
            $array['id'],
            $array['userId'],
            $array['parentId'],
            $array['text'],
            $array['memo'],
            Carbon::parse($array['startDateTime']),
            Carbon::parse($array['stopDateTime']),
            Carbon::parse($array['deadlineDate']),
            $array['deadlineSecond'],
            $array['status'],
            $array['displaySequence']
        );
    }

    public function rebuildFromEloquent($eloquent): TicketEntity
    {
        return $this->rebuild(
            $eloquent->id,
            $eloquent->user_id,
            $eloquent->parent_id,
            $eloquent->text,
            $eloquent->memo,
            Carbon::parse($eloquent->start_date_time),
            Carbon::parse($eloquent->stop_date_time),
            Carbon::parse($eloquent->deadline_date),
            $eloquent->deadline_second,
            $eloquent->status,
            $eloquent->display_sequence
        );
    }
}
