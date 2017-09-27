<?php

namespace App\Http\Controllers\Api;

use App\DailyMenu;
use App\Food;
use App\Http\Requests\Api\OrderCreateRequest;
use App\Material;
use App\Order;
use App\OrderItem;
use Faker\Provider\DateTime;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Psy\Exception\ErrorException;

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
     * @param \Illuminate\Http\Request $request request get order
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->order->setColumnsFilter([
            'id',
            'status',
            'created_at',
            'total_price'
        ]);
        $this->order->setColumnsCondition(['user_id' => $request->user()->id]);
        $order = $this->order->search()->paginate(Order::ITEMS_PER_PAGE);
        return $order;
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
     * @param OrderCreateRequest $request request create
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OrderCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = $this->order->create(
                [
                    'user_id' => $request->input('user_id'),
                    'trans_at' => $request->input('trans_at'),
                    'custom_address' => $request->address_ship,
                    'status' => Order::STATUS_PENDING
                ]
            );
            if ($request->type == 'App\Food') {
                $itemtable = new Food();
                foreach ($request->items as $item) {
                    $dailyItem = DailyMenu::where('date', '=', date("Y-m-d", strtotime($request->trans_at)))
                        ->where('food_id', '=', $item['id'])
                        ->take(1)->get();
                    if (count($dailyItem->all()) != 0) {
                        $itemtable->findOrFail($dailyItem[0]->food_id);
                        $this->orderItem->create(
                            [
                                'itemtable_id' => $item['id'],
                                'itemtable_type' => $request->input('type'),
                                'quantity'=> $item['quantity'],
                                'order_id' => $order->id
                            ]
                        );
                        $dailyItem[0]->quantity -= $item['quantity'];
                        $dailyItem[0]->saveOrFail();
                    }
                }
            } elseif ($request->type == 'App\Material') {
                $itemtable = new Material();
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
            return response()->json(
                json_decode($e->getResponse()->getBody(), true),
                $e->getCode()
            );
        }
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
                }, 'orderItems.itemtable'])->findOrFail($id);
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
