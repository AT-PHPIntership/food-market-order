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
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function itemtable()
    {
        return $this->morphTo();
    }
}
