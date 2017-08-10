<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * Return all food item in database with paginate by 10 item per page
     *
     * @return array Food object
     */
  	public static function getAll()
  	{
  		return self::join('categories', 'category_id', '=', 'categories.id')
                     ->select('foods.*', 'categories.name as category_name')
                     ->get();
  	}

    /**
     * Food has many order item
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'itemtable');
    }
}
