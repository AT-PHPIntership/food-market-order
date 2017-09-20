<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderItemController extends ApiController
{
    /**
     * Variable common object Order
     *
     * @var Order $order
     */
    private $order;

    /**
     * Variable common object Order
     *
     * @var OrderItem $orderItem
     */
    private $orderItem;

    /**
     * OrderController constructor.
     *
     * @param Order     $order     It is param input constructors
     * @param OrderItem $orderItem It is param input constructors
     */
    public function __construct(Order $order, OrderItem $orderItem)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request create
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id id order item
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id order item
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request update
     * @param int                      $id      id order item update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = $request;
        $id = $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request request update
     * @param int                      $id      id delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $orderItem = $this->orderItem->findOrFail($id);
        $order = $this->order->findOrFail($orderItem->order_id);
        if ($order->user_id != $request->user()->id || $order->status != 1) {
            return response()->json(['message' => 'Client Authentication'], 403);
        }
        if ($orderItem->delete()) {
            $orderItem = $this->orderItem->onlyTrashed()
                ->select(['id', 'itemtable_type', 'quantity', 'order_id', 'itemtable_id', 'deleted_at'])
                ->with('itemtable')->findOrFail($id);
            return response()->json([
                'data' => $orderItem,
                'success' => true
            ], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'The request is for something forbidden.'], 403);
        }
    }
}
