<?php

namespace App\Http\Controllers\Api;

use App\Order;
use Illuminate\Http\Request;
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
     * OrderController constructor.
     *
     * @param Order $order It is param input constructors
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
                ]);
            dd($order);
            DB::commit();
            return ['data' => $this->data];
        } catch (EXCEPTION $e) {
            DB::rollback();
                    throw $e;
        }
    //        return $request->all();
    }

/**
 * Display the specified resource.
 *
 * @param int $id id supplier
 *
 * @return \Illuminate\Http\Response
 */
public
function show($id)
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
public
function edit($id)
{
    $id = $id;
}

/**
 * Update the specified resource in storage.
 *
 * @param \Illuminate\Http\Request $request request update
 * @param int $id id supplier update
 *
 * @return \Illuminate\Http\Response
 */
public
function update(Request $request, $id)
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
public
function destroy($id)
{
    $id = $id;
}
}
