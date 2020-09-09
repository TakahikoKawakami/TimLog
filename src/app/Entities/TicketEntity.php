<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Support\Str;

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
    protected $runStartDateTime;
    protected $runStopDateTime;
    protected $runtimeSecond;
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
        Carbon $runStartDateTime,
        Carbon $runStopDateTime,
        int $runtimeSecond,
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
        $this->runStartDateTime = $runStartDateTime;
        $this->runStopDateTime = $runStopDateTime;
        $this->runtimeSecond = $runtimeSecond;
        $this->status = $status;
        $this->displaySequence = $displaySequence;
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public function bulkUpdateByArray(array $array): void
    {
        foreach ($array as $key => $value) {
            if ($this->has($key)) {
                // Str::studly 頭文字を大文字に変換する（pascal case）
                $methodName = "update" . Str::studly($key);
                $this->$methodName($value);
            }
        }
    }

    public function updateParentId(int $value)
    {
        $this->parentId = $value;
    }

    public function updateText(string $value)
    {
        $this->text = $value;
    }

    public function updateMemo(?string $value)
    {
        $this->memo = $value;
    }

    public function updateStartDateTime(Carbon $value)
    {
        $this->startDateTime = $value;
    }

    public function updateStopDateTime(Carbon $value)
    {
        $this->stopDateTime = $value;
    }

    public function updateDeadlineDate(Carbon $value)
    {
        $this->deadlineDate = $value;
    }

    public function updateDeadlineSecond(int $value)
    {
        $this->deadlineSecond = $value;
    }

    public function updateRunStartDateTime(Carbon $value)
    {
        $this->runStartDateTime = $value;
    }

    public function updateRunStopDateTime(Carbon $value)
    {
        $this->runStopDateTime = $value;
    }

    public function updateRuntimeSecond(int $value)
    {
        $this->runtimeSecond = $value;
    }

    public function updateStatus(int $value)
    {
        $this->status = $value;
    }

    public function updateDisplaySequence(int $value)
    {
        $this->displaySequence = $value;
    }

    public function has($key)
    {
        $thisArray = $this->toArray();
        return isset($thisArray[$key]) ? true : false;
    }
}
