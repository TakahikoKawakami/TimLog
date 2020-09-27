<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtil;
use App\Services\TicketService;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Factories\TicketFactoryInterface;
use App\Http\Requests\Ticket\GetTicketRequest;
use App\Repositories\TicketRepositoryInterface;
use App\Http\Requests\Ticket\CreateTicketRequest;
use App\Http\Requests\Ticket\DeleteTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Factories\TicketDisplaySequenceFactoryInterface;
use App\Repositories\TicketDisplaySequenceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

use Illuminate\Foundation\Application as Application; //DI利用のため

class TicketController extends Controller
{
    protected $ticketFactory;
    protected $ticketRepository;
    protected $ticketService;

    protected $responseService;

    protected $displaySequenceFactory;
    protected $displaySequenceRepository;
    protected $ticketDisplaySequenceService;

    public function __construct(Application $app)
    {
        $this->ticketService = $app->make('TicketService');
        $this->ticketDisplaySequenceService = $app->make('TicketDisplaySequenceService');
        $this->responseService = $app->make('ResponseService');
    }

    public function index()
    {
        $tickets = $this->ticketService->getTickets();
        return view('index-bootstrap')->with(["tickets"=>$tickets]);
    }

    public function apiIndex(GetTicketRequest $request): JsonResponse
    {
        $user = auth()->user();
        $requestBody = $request->all();
        $requestBody['user_id'] = $user->id;
        $tickets = $this->ticketService->getTickets($requestBody);
        $ticketArray = $tickets->toArray();
        $tickets = ArrayUtil::toSnakeKeys($ticketArray);

        // return response()->json($tickets);
        return $this->responseService->makeResponse($tickets);
    }

    public function apiGet(GetTicketRequest $request): JsonResponse
    {
        $user = auth()->user();
        $requestBody = $request->all();
        $requestBody['user_id'] = $user->id;
        $tickets = $this->ticketService->getTicketById($requestBody);
        $ticketArray = $tickets->toArray();
        $tickets = ArrayUtil::toSnakeKeys($ticketArray);

        // return response()->json($tickets);
        return $this->responseService->makeResponse($tickets);
    }


    public function apiCreate(CreateTicketRequest $request): JsonResponse
    {
        $user = auth()->user();
        $requestBody = $request->all();
        $requestBody['user_id'] = $user->id;
        try {
            DB::beginTransaction();
            $newTicketEntity = $this->ticketService->createTicket($requestBody);
            $returnTicket = ArrayUtil::toSnakeKeys($newTicketEntity->toArray());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error');
            throw $e;
        }
        return response()->json($returnTicket);
    }

    public function apiUpdate(UpdateTicketRequest $request, int $id)
    {
        try {
            DB::beginTransaction();
            $newTicketEntity = $this->ticketService->updateTicket($id, $request->all());
            $returnTicket = ArrayUtil::toSnakeKeys($newTicketEntity->toArray());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error');
            throw $e;
        }
        return response()->json($returnTicket);
        // return $request;
    }

    public function apiDelete(int $id)
    {
        try {
            DB::beginTransaction();
            $successOrFailure = $this->ticketService->deleteTicket($id);
            $successOrFailure = $this->ticketDisplaySequenceService->deleteByTicketId($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error');
            throw $e;
        }
        return response()->json(['success' => $successOrFailure]);
    }
    /**
     * CollectionとPaginatorからレスポンスを生成
     *
     * @param EloquentCollection $items
     * @param integer $countFullCollection
     * @param LengthAwarePaginator $paginator
     * @return Response
     */
    // private function setJsonResponseWithPaginator(EloquentCollection $items, int $countFullCollection, LengthAwarePaginator $paginator): Response
    // {
    //     $itemsArray = ArrayUtil::toCamelKeys($items->toArray());
    //     $res = response(json_encode( $itemsArray , JSON_UNESCAPED_UNICODE), 200)
    //             ->header('Content-Type', 'application/json')
    //             ->header('Total', $paginator->total())
    //             ->header('Current-Page', $paginator->currentPage())
    //             ->header('Per-Page', $paginator->perPage());
    //     if($countFullCollection > 0) {
    //         $res -> header('Link', "<{$paginator->previousPageUrl()}>; rel=\"prev\",<{$paginator->nextPageUrl()}>; rel=\"next\",");
    //     }
    //     return $res;
    // }
}
