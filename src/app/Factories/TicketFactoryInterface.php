<?php
namespace App\Factories;
use Carbon\Carbon;

use App\Entities\TicketEntity;

interface TicketFactoryInterface
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
    ): TicketEntity;

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
    ): TicketEntity;

    public function buildFromArray(array $array): TicketEntity;

    public function rebuildFromArray(array $array): TicketEntity;

    public function rebuildFromEloquent($eloquent): TicketEntity;

}
