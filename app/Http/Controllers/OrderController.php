<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;

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
        // Filter date and key input
        if ($request->has('date')) {
            $orders = $this->order->with('user')
                ->whereDate('updated_at', '=', $request->date)
                ->orWhereDate('created_at', '=', $request->date)
                ->orWhereDate('trans_at', '=', $request->date)
                ->paginate(10);
        } elseif ($request->has('key')) {
            $orders = $this->order
                ->whereHas('user', function ($query) use ($request) {
                    $query->where('full_name', 'like', '%'.$request->key.'%');
                })
                ->orWhere('custom_address', 'like', '%'.$request->key.'%')
                ->orWhere('payment', 'like', '%'.$request->key.'%')
                ->paginate(10);
        } else {
            $orders = $this->order
                ->with('user')
                ->paginate(10);
        }
        return view('orders.index', ['orders' => $orders]);
    }
}
