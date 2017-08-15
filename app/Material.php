<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use softDeletes;

    const ROWS_LIMIT = 10;
    protected $table = "materials";
    protected $fillable = ['id', 'name', 'category_id', 'suppliers', 'price', 'description','image'];

    /**
     * Material has many order item
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'itemtable');
    }

    /**
     * Material has one Category
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * Material has one Suplier
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
    }
}
