<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use softDeletes;

    /**
     * Order item morph to food and material
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function itemtable()
    {
        return $this->morphTo();
    }
}
