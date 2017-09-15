<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\OrderItem;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends ApiController
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
        $request = $request;
    }

    /**
     * Display the specified resource.
     *
     * @param int                      $id      id of order
     * @param \Illuminate\Http\Request $request request get items
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        try {
            $user = $request->user();
            $data = [];
            $order = $this->order
                ->select(['orders.id as id', 'user_id', 'orders.created_at', 'orders.updated_at', 'trans_at', 'total_price', 'status',
                    'custom_address as address'])
                ->with(['orderItems' => function ($query) {
                    $query->select(['id', 'itemtable_type', 'quantity', 'order_id', 'itemtable_id']);
                    $query->with(['itemtable' => function ($query) {
                        $query->select(['itemtable.id','itemtable.price' ,'itemtable.name' , 'itemtable.image']);
                    }]);
                }])->findOrFail($id);
            if ($user->id == $order->user_id) {
                $data = $order;
            }
            return response()->json([
                'data' => $data,
                'success' => true
            ], Response::HTTP_OK);
        } catch (ClientException $ex) {
            return  response()->json(
                json_decode($ex->getResponse()->getBody(), true),
                $ex->getCode()
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id supplier
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
     * @param int                      $id      id supplier update
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
     * @param int $id id delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = $id;
    }
}
