<?php

namespace App\Services;

use App\Entities\TicketDisplaySequenceCollection;
use Carbon\Carbon;
use App\Entities\TicketEntity;
use App\Entities\TicketDisplaySequenceEntity;
use App\Factories\TicketDisplaySequenceFactoryInterface;
use App\Http\Controllers\TicketDisplaySequenceController;
use App\Repositories\TicketDisplaySequenceRepositoryInterface;

use Illuminate\Foundation\Application as Application; //DI利用のため

class TicketDisplaySequenceService
{
    protected $userRepository;

    protected $displaySequenceFactory;
    protected $displaySequenceRepository;

    public function __construct(Application $app)
    {
        $this->displaySequenceFactory = $app->make('TicketDisplaySequenceFactory');
        $this->displaySequenceRepository = $app->make('TicketDisplaySequenceRepository');
    }

    public function getTicketById(?array $queryArray = null)
    {
        return $this->ticketRepository->getTickets($queryArray);
    }

    public function getTickets(?array $queryArray = null)
    {
        return $this->ticketRepository->getTickets($queryArray);
    }

    public function create(array $fieldsArray): TicketDisplaySequenceEntity
    {
        $newTicketEntity = $this->displaySequenceFactory->buildFromArray($fieldsArray);
        return $this->displaySequenceRepository->store($newTicketEntity);
    }

    public function update(array $fieldsArray): TicketDisplaySequenceCollection
    {
        $targetEntities = [];
        foreach($fieldsArray as $fields) {
            $exists = $this->displaySequenceRepository->getByTicketId($fields['ticket_id']);
            if (is_null($exists)) {
                $targetEntities[] = $this->displaySequenceFactory->buildFromArray($fields);
            } else {
                $exists->bulkUpdateByArray($fields);
                $targetEntities[] = $exists;
            }
        }
        return $this->displaySequenceRepository->storeAll($targetEntities);
    }

    public function deleteByTicketId(int $ticketId): bool
    {
        $targetTicketEntity = $this->displaySequenceRepository->deleteByTicketId($ticketId);
        return true;
    }

}

