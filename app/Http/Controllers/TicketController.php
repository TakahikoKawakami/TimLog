<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\TicketRepositoryInterface;
use App\Services\TicketService;
use App\Utils\ArrayUtil;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TicketController extends Controller
{
    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        $ticketService = new TicketService($this->ticketRepository);
        $tickets = $ticketService->getTickets();
        return view('index-bootstrap')->with(["tickets"=>$tickets]);
    }

    public function apiIndex()
    {
        $ticketService = new TicketService($this->ticketRepository);
        $tickets = $ticketService->getTickets();
        $ticketArray = $tickets->toArray();
        $tickets = ArrayUtil::toSnakeKeys($ticketArray);

        return json_encode($tickets);
    }

    /**
     * CollectionとPaginatorからレスポンスを生成
     *
     * @param EloquentCollection $items
     * @param integer $countFullCollection
     * @param LengthAwarePaginator $paginator
     * @return Response
     */
    private function setJsonResponseWithPaginator(EloquentCollection $items, int $countFullCollection, LengthAwarePaginator $paginator): Response
    {
        $itemsArray = ArrayUtil::toCamelKeys($items->toArray());
        $res = response(json_encode( $itemsArray , JSON_UNESCAPED_UNICODE), 200)
                ->header('Content-Type', 'application/json')
                ->header('Total', $paginator->total())
                ->header('Current-Page', $paginator->currentPage())
                ->header('Per-Page', $paginator->perPage());
        if($countFullCollection > 0) {
            $res -> header('Link', "<{$paginator->previousPageUrl()}>; rel=\"prev\",<{$paginator->nextPageUrl()}>; rel=\"next\",");
        }
        return $res;
    }
}
