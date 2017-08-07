<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    /**
     * Get the category for the food.
     *
     * @return relationship
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }
}
