<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
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
     * @param \Illuminate\Http\Request $request Request from client
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = $this->order;
        // Filter date and key input
        if ($request->has('date')) {
            $orders = $orders->with('user')
                ->whereDate('updated_at', '=', $request->date)
                ->orWhereDate('created_at', '=', $request->date)
                ->orWhereDate('trans_at', '=', $request->date);
        } elseif ($request->has('keyword')) {
            $orders = $orders->whereHas('user', function ($query) use ($request) {
                $query->where('full_name', 'like', '%' . $request->keyword . '%');
            })
                ->orWhere('custom_address', 'like', '%' . $request->keyword . '%')
                ->orWhere('payment', 'like', '%' . $request->keyword . '%');
        } else {
            $orders = $orders->with('user');
        }
        $orders = $orders->paginate(Order::ITEMS_PER_PAGE);
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
                    flash(__('Delete Item Success'))->success()->important();
                } else {
                    flash(__('Delete Item Errors'))->error()->important();
                }
            } else {
                flash(__('Delete Item Errors'))->error()->important();
            }
        } catch (ModelNotFoundException $ex) {
            flash(__('Order Item Not Found'))->error()->important();
        }
        return back();
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
                    flash(__('Update Item ' . $id . ' Success'))->success()->important();
                } else {
                    flash(__('Update Item Errors'))->error()->important();
                }
            } else {
                flash(__('Update Item Errors'))->error()->important();
            }
        } catch (ModelNotFoundException $ex) {
            flash(__('Order Item Not Found'))->error()->important();
        }
        return back();
    }
}
