<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtil;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\TicketDisplaySequenceService;
use App\Factories\TicketDisplaySequenceFactoryInterface;
use App\Repositories\TicketDisplaySequenceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use App\Http\Requests\TicketDisplaySequence\CreateTicketDisplaySequenceRequest;
use App\Http\Requests\TicketDisplaySequence\UpdateTicketDisplaySequenceRequest;

use Illuminate\Foundation\Application as Application; //DI利用のため

class TicketDisplaySequenceController extends Controller
{
    protected $displaySequenceFactory;
    protected $displaySequenceRepository;
    protected $ticketDisplaySequenceService;

    protected $responseService;

    public function __construct(Application $app)
    {
        // $this->middleware('auth');
        $this->ticketDisplaySequenceService = $app->make('TicketDisplaySequenceService');
        $this->responseService = $app->make('ResponseService');
    }

    public function apiCreate(CreateTicketDisplaySequenceRequest $request)
    {
        try {
            DB::beginTransaction();
            $newTicketDisplaySequenceEntity = $this->ticketDisplaySequenceService->create($request->all());
            $returnTicket = ArrayUtil::toSnakeKeys($newTicketDisplaySequenceEntity->toArray());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error');
            throw $e;
        }
        return response()->json($returnTicket);
        // return $request;
    }

    public function apiUpdate(UpdateTicketDisplaySequenceRequest $request)
    {
        try {
            DB::beginTransaction();
            $newTicketDisplaySequenceEntity = $this->ticketDisplaySequenceService->update($request->sortArray);
            $returnTicket = ArrayUtil::toSnakeKeys($newTicketDisplaySequenceEntity->toArray());
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
