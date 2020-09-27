<?php

namespace App\Repositories;

use App\Entities\TicketDisplaySequenceCollection;
use App\Entities\TicketDisplaySequenceEntity;

interface TicketDisplaySequenceRepositoryInterface
{
    public function getById(int $id, bool $getDeleted = false): ?TicketDisplaySequenceEntity;

    public function getByTicketId(int $ticketId, bool $getDeleted = false): ?TicketDisplaySequenceEntity;

    public function store(TicketDisplaySequenceEntity $displaySequenceEntity): ?TicketDisplaySequenceEntity;

    public function storeAll(array $displaySequenceEntities): ?TicketDisplaySequenceCollection;

    public function deleteByTicketId(int $ticketId): bool;

}
