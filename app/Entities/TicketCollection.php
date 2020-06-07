<?php

namespace App\Entities;

use App\Entities\TicketEntity;

class TicketCollection extends Collection
{
    public $collection;
    public function __construct($collection)
    {
        $this->collection = $collection;
    }
}
