<?php

namespace App;

use App\Libraries\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Searchable;
    use SoftDeletes;

    const ITEMS_PER_PAGE = 10;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [

        'columns' => [
            'users.full_name',
            'orders.trans_at',
            'orders.custom_address',
            'orders.total_price',
            'orders.status',
        ],
        'joins' => [
            'users' => ['orders.user_id', 'users.id']
        ]
    ];

    /**
     * Order has many order item.
     *
     * @return array
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    /**
     * Order belongsTo User
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Update Total Price of Order
     *
     * @param int $id It is id of order need updateTotalPrice.
     *
     * @return bool
     */
    public function updateTotalPrice($id)
    {
        $order = Order::with('orderItems.itemtable')->findOrFail($id);
        $order->total_price = 0;
        foreach ($order->orderItems as $orderItem) {
            $item = $orderItem->itemtable;
            $order->total_price += $item->price * $orderItem->quantity;
        }
        if ($order->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This is a recommended way to declare event handlers
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            $order->orderItems()->delete();
        });
    }
}
