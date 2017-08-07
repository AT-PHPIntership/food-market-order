<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use softDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    function orderItems ()
    {
        return $this->morphMany(OrderItem::class, 'itemtable');
    }
}
