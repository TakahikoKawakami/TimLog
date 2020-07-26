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

    public function updateMemo(string $value)
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
