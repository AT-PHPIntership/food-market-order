<?php

namespace App\Http\Controllers\Api;

use App\DailyMenu;
use App\Food;
use App\Material;
use App\Order;
use App\OrderItem;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $order = $this->order->findOrFail($id);
            $order->custom_address = $request->address_ship;
            $order->trans_at = $request->trans_at;
            // order is not pending return false
            if ($order->status != 1) {
                return false;
            }
            $order->saveOrFail();
            foreach ($request->items as $item) {
                $orderItem = $this->orderItem->where('order_id', $id)
                    ->where('itemtable_id', $item['id'])->first();
                if ($orderItem->itemtable_type == 'App\Food') {
                    $dailyItem = DailyMenu::where('date', '=', date("Y-m-d", strtotime($request->trans_at)))
                        ->where('food_id', '=', $item['id'])
                        ->take(1)->first();
                    if (count($dailyItem->all()) != 0) {
                        $dailyItem->quantity -=  $item['quantity'] - $orderItem->quantity;
                        $dailyItem->saveOrFail();
                        $orderItem->quantity = $item['quantity'];
                    }
                    $orderItem->saveOrFail();
                }
                if ($orderItem->itemtable_type == 'App\Material') {
                    $orderItem->quantiy = $item['quantity'];
                    $orderItem->saveOrFail();
                }
            }
            $order->updateTotalPrice();

            DB::commit();
            $data = [
                'order_id' => $order->id,
                'user_id'=> $order->user_id,
                'address_ship'=> $order->custom_address,
                'total_price'=> $order->total_price
            ];
            return response()->json([
                'data' => $data,
                'success' => true
            ], Response::HTTP_OK);
        } catch (ClientException $e) {
            DB::rollback();
            return response()->json([
                json_decode($e->getResponse()->getBody(), true)
            ], $e->getCode());
        } catch (QueryException $ex) {
            DB::rollback();
            return response()->json([
                'error' => $ex->errorInfo[0],
                'message' => $ex->errorInfo[2]
            ], 404);
        }
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
