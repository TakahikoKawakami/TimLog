<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Entities\TicketDisplaySequenceCollection;
use App\Model\TicketDisplaySequence;
use App\Entities\TicketDisplaySequenceEntity;
use App\Factories\TicketDisplaySequenceFactoryInterface;
use App\Repositories\TicketDisplaySequenceRepositoryInterface;

use Illuminate\Foundation\Application as Application; //DI利用のため
class TicketDisplaySequenceRepository implements TicketDisplaySequenceRepositoryInterface
{
    protected $ticketDisplaySequenceEloquent;
    protected $ticketDisplaySequenceFactory;

    public function __construct(Application $app)
    {
        $this->ticketDisplaySequenceFactory = $app->make('TicketDisplaySequenceFactory');
        $this->ticketDisplaySequenceEloquent = new TicketDisplaySequence();
    }

    public function store(TicketDisplaySequenceEntity $displaySequenceEntity): ?TicketDisplaySequenceEntity
    {
        $request = $displaySequenceEntity->toArray();

        // insert時、idにはnullが入っているので、削除する
        if (is_null($request['id'])) {
            unset($request['id']);
            return $this->insert($request);
        }
        // update時はそのまま
        return $this->update($request);
    }

    public function storeAll(array $displaySequenceEntities): ?TicketDisplaySequenceCollection
    {
        $results = collect();
        foreach ($displaySequenceEntities as $entity) {
            $results->push($this->store($entity));
        }

        return new TicketDisplaySequenceCollection($results);
    }

    public function getById(int $id, bool $getDeleted = false): ?TicketDisplaySequenceEntity
    {
        $eloquent = $this->ticketDisplaySequenceEloquent->where('id', $id);

        $record = $eloquent->first();
        if (is_null($record)) {
            return null;
        }
        return $this->ticketDisplaySequenceFactory->rebuildFromEloquent($record);
    }

    public function getByTicketId(int $ticketId, bool $getDeleted = false): ?TicketDisplaySequenceEntity
    {
        $eloquent = $this->ticketDisplaySequenceEloquent->where('ticket_id', $ticketId);

        $record = $eloquent->first();
        if (is_null($record)) {
            return null;
        }
        return $this->ticketDisplaySequenceFactory->rebuildFromEloquent($record);
    }

    public function deleteByTicketId(int $ticketId): bool
    {
        $target = $this->getByTicketId($ticketId, true);
        $eloquent = $this->ticketDisplaySequenceEloquent->destroy($target->id());
        return true;
    }

    /**
     * チケットを新規登録する
     * TicketModelのfillableで指定されたフィールドのみ更新される
     *
     * @param array $request
     * @return TicketDisplaySequenceEntity
     */
    private function insert(array $request): ?TicketDisplaySequenceEntity
    {
        $fillArray = [];
        foreach ($request as $key => $value) {
            $fillArray[Str::snake($key)] = $value;
        }
        $this->ticketDisplaySequenceEloquent->fill($fillArray)->save();

        return $this->getById($this->ticketDisplaySequenceEloquent->id, false);
    }

    private function update(array $request): ?TicketDisplaySequenceEntity
    {
        $fillArray = [];
        foreach ($request as $key => $value) {
            $fillArray[Str::snake($key)] = $value;
        }
        $this->ticketDisplaySequenceEloquent->find($fillArray['id'])->update($fillArray);

        return $this->getById($fillArray['id'], false);
    }

}
