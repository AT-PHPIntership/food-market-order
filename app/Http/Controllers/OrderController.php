<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\Exception;

class OrderController extends Controller
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
        $orders = $this->order->search()->paginate(Order::ITEMS_PER_PAGE);
        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request from client
     * @param int                      $id      It is id order need update change status
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $order = $this->order->findOrFail($id);
            $order->status = $request->input('status');
            if ($order->save()) {
                flash(__('Change Status Success'))->success()->important();
            } else {
                flash(__('Change Errors'))->error()->important();
            }
        } catch (ModelNotFoundException $ex) {
            flash(__('Order Not Found'))->error()->important();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id It is id order need delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order = $this->order->findOrFail($id);
            $order->orderItems()->delete();
            if ($order->delete()) {
                flash(__('Delete Order Success'))->success()->important();
            } else {
                flash(__('Delete Order Errors'))->error()->important();
            }
        } catch (ModelNotFoundException $ex) {
            flash(__('Order Not Found'))->error()->important();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id It is id of order need show detail
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->order->with('orderItems.itemtable')->with('user')->findOrFail($id);
        return view('orders.show', ['order' => $order]);
    }
}
