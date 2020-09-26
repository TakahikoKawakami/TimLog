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
        Carbon $runStartDateTime,
        Carbon $runStopDateTime,
        int $runtimeSecond,
        int $status,
        int $displaySequence
    ): TicketEntity
    {
        $runStart = $startDateTime->toString();
        $runStop = $stopDateTime->toString();
        $runstart = $runStartDateTime->format('Y-m-d h:i:s');
        $runstop = $runStartDateTime->format('Y-m-d h:i:s');
        $runstart = $runStartDateTime->format('Y-m-d h:i:s');
        $runstop = $runStartDateTime->format('Y-m-d h:i:s');
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
            $runStartDateTime,
            $runStopDateTime,
            $runtimeSecond,
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
        Carbon $runStartDateTime,
        Carbon $runStopDateTime,
        int $runtimeSecond,
        int $status,
        int $displaySequence
    ): TicketEntity
    {
        $runstart = $runStartDateTime->format('Y-m-d h:i:s');
        $runstop = $runStopDateTime->format('Y-m-d h:i:s');

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
            $runStartDateTime,
            $runStopDateTime,
            $runtimeSecond,
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
            $array['user_id'],
            $array['parent_id'],
            $array['text'],
            $array['memo'],
            Carbon::parse($array['start_date_time']),
            Carbon::parse($array['stop_date_time']),
            Carbon::parse($array['deadline_date']),
            $array['deadline_second'],
            Carbon::parse($array['run_start_date_time']),
            Carbon::parse($array['run_stop_date_time']),
            $array['runtime_second'],
            $array['status'],
            $array['display_sequence']
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
            Carbon::parse($eloquent->run_start_date_time),
            Carbon::parse($eloquent->run_stop_data_time),
            $eloquent->runtime_second,
            $eloquent->status,
            $eloquent->display_sequence
        );
    }
}
