<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use softDeletes;

    /**
     * Material has many order items
     *
     * @return mixed
     */
    public function itemtable()
    {
        return $this->morphTo();
    }
}
