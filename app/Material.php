<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use softDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orderItems ()
    {
        return $this->morphMany(OrderItem::class, 'itemtable');
    }
}
