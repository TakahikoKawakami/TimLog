<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Entities\BaseEntity;
use Illuminate\Support\Collection;

class TicketDisplaySequenceCollection extends Collection
{
    public $collection;
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function toArray(): array
    {
        $result = [];
        $allEntities = $this->collection->toArray();
        foreach ($allEntities as $value) {
            $result[] = $value->toArray();
        }
        return $result;
    }
}
