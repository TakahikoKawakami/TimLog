<?php

namespace App\Entities;

use App\Entities\TicketEntity;
use Illuminate\Support\Collection;

class TicketCollection extends Collection
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
