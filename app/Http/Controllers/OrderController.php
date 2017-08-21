<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
        $order = $this->order->with('orderItems.itemtable')->with('user')->find($id);
        return view('orders.show', ['order' => $order]);
    }

    /**
     * Remove order item
     *
     * @param int $id It is id of order item need detele.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteItem($id)
    {
        try {
            $orderItem = OrderItem::with('itemtable')->with('order')->find($id);
            $item = $orderItem->itemtable;
            $order = $orderItem->order;
            $order->payment = $order->payment - $item->price * $orderItem->quantity;
            if ($order->save()) {
                if ($orderItem->delete()) {
                    $message = __('Delete Item ' . $id . ' Success');
                    $status = Response::HTTP_OK;
                } else {
                    $message = __('Delete Item ' . $id . ' Errors');
                    $status = Response::HTTP_NOT_FOUND;
                }
            } else {
                $message = __('Delete Item Errors');
                $status = Response::HTTP_NOT_FOUND;
            }
        } catch (ModelNotFoundException $ex) {
            $message = __('Order Item Not Found');
            $status = Response::HTTP_NOT_FOUND;
        }
        return response()->json(['message' => $message], $status);
    }

    /**
     * Update order item
     *
     * @param \Illuminate\Http\Request $request Request from client
     * @param int                      $id      It is id of order item need update
     *
     * @return \Illuminate\Http\Response
     */
    public function updateItem(Request $request, $id)
    {
        try {
            $orderItem = OrderItem::with('itemtable')->with('order')->find($id);
            $item = $orderItem->itemtable;
            $order = $orderItem->order;
            $quantityChange = $orderItem->quantity;
            $orderItem->quantity = $request->input('quantity');
            $quantityChange = $orderItem->quantity - $quantityChange;
            $order->payment = $order->payment + $item->price * $quantityChange;
            if ($order->save()) {
                if ($orderItem->save()) {
                    $message = __('Update Item ' . $id . ' Success');
                    $status = Response::HTTP_OK;
                } else {
                    $message = __('Update Item Errors');
                    $status = Response::HTTP_OT_FOUND;
                }
            } else {
                $message = __('Update Item Errors');
                $status = Response::HTTP_NOT_FOUND;
            }
        } catch (ModelNotFoundException $ex) {
            $message = __('Order Item Not Found');
            $status = Response::HTTP_NOT_FOUND;
        } catch (QueryException $ex) {
            $message = __('Update Item Errors');
            $status = Response::HTTP_NOT_FOUND;
        }
        return response()->json(['message' => $message], $status);
    }
}
