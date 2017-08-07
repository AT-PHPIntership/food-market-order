<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use softDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function itemtable ()
    {
        return $this->morphTo();
    }
}
