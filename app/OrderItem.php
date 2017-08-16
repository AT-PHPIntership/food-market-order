<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];

    /**
     * Material has many order items
     *
     * @return mixed
     */
    public function itemtable()
    {
        return $this->morphTo();
    }

    /**
     * OrderItem has one Order
     *
     * @return mixed
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
