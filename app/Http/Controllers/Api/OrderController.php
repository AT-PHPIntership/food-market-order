<?php

namespace App\Http\Controllers\Api;

use App\Food;
use App\Material;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

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
        return "Add order";
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
        DB::beginTransaction();
        try {
            $order = $this->order->create(
                [
                    'user_id' => $request->input('user_id'),
                    'trans_at' => $request->input('trans_at'),
                    'custom_address' => $request->address_ship,
                    'status' => 1
                ]
            );
            if ($request->type == 'App\Food') {
                $itemtable = new Food();
            } else {
                $itemtable = new Material();
            }
            foreach ($request->items as $item) {
                $itemtable->findOrFail($item['id']);
                $this->orderItem->create(
                    [
                        'itemtable_id' => $item['id'],
                        'itemtable_type' => $request->input('type'),
                        'quantity'=> $item['quantity'],
                        'order_id' => $order->id
                    ]
                );
            }
            $order->updateTotalPrice();
            DB::commit();
            $data = [
                'order_id' => $order->id,
                'user_id'=> $order->user_id,
                'address_ship'=> $order->custom_address,
                'trans_at'=> $order->trans_at,
                'total_price'=> $order->total_price
            ];
            return response()->json([
                'data' => $data,
                'success' => true
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'data_invalid',
                'message' => true
            ], Response::HTTP_BAD_REQUEST);
        }
        //    return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id id supplier
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
