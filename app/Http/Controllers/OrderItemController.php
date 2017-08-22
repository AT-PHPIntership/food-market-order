<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    /**
     * Variable common object Order
     *
     * @var Order $order
     */
    private $order;

    /**
     * Variable common object OrderItem
     *
     * @var OrderItem $orderItem
     */
    private $orderItem;

    /**
     * OrderController constructor.
     *
     * @param OrderItem $orderItem It is param input constructors
     * @param Order     $order     It is param input constructors
     */
    public function __construct(OrderItem $orderItem, Order $order)
    {
        $this->orderItem = $orderItem;
        $this->order = $order;
    }

    /**
     * Update order item
     *
     * @param \Illuminate\Http\Request $request Request from client
     * @param int                      $id      It is id of order item need update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $orderItem = $this->orderItem->with('order')->findOrFail($id);
            $orderItem->quantity = $request->quantity;
            if ($orderItem->save()) {
                if ($this->order->updateTotalPrice($orderItem->order->id)) {
                    $message = __('Update Item ' . $id . ' Success');
                    $status = Response::HTTP_OK;
                } else {
                    $message = __('Update Item Errors');
                    $status = Response::HTTP_BAD_REQUEST;
                }
            } else {
                $message = __('Update Item Errors');
                $status = Response::HTTP_BAD_REQUEST;
            }
        } catch (ModelNotFoundException $ex) {
            $message = __('Order Item Not Found');
            $status = Response::HTTP_BAD_REQUEST;
        } catch (QueryException $ex) {
            $message = __('Update Item Errors');
            $status = Response::HTTP_BAD_REQUEST;
        }
        return response()->json(['message' => $message], $status);
    }

    /**
     * Remove order item
     *
     * @param int $id It is id of order item need detele.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $orderItem = $this->orderItem->with('order')->findOrFail($id);
            $orderID = $orderItem->order->id;
            if ($orderItem->delete()) {
                if ($this->order->updateTotalPrice($orderID)) {
                    $message = __('Delete Item ' . $id . ' Success');
                    $status = Response::HTTP_OK;
                } else {
                    $message = __('Delete Item ' . $id . ' Errors');
                    $status = Response::HTTP_BAD_REQUEST;
                }
            } else {
                $message = __('Delete Item ' . $id . ' Errors');
                $status = Response::HTTP_BAD_REQUEST;
            }
        } catch (ModelNotFoundException $ex) {
            $message = __('Order Item Not Found');
            $status = Response::HTTP_BAD_REQUEST;
        }
        return response()->json(['message' => $message], $status);
    }
}
