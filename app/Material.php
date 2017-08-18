<?php

namespace App;

use App\Libraries\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use Searchable;
    use softDeletes;

    const ITEMS_PER_PAGE = 10;

    protected $table = "materials";

    protected $fillable = ['id', 'name', 'category_id', 'supplier_id', 'price', 'description','image', 'status'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         */

        'columns' => [
            'materials.name' => 10,
            'categories.name' => 8,
            'suppliers.name' => 8,
            'materials.description' => 5,
            'materials.price' => 2,
        ],
        'joins' => [
            'categories' => ['materials.category_id', 'categories.id'],
            'suppliers' => ['materials.supplier_id', 'suppliers.id']
        ]
    ];

    /**
     * Material has many order item
     *
     * @return mixed
     */
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'itemtable');
    }

    /**
     * Material has one Category
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * Material has one Suplier
     *
     * @return mixed
     */
    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
    }

    /**
     * Get Image Attribute
     *
     * @param string $image get attribute image
     *
     * @return string
     */
    public function getImageAttribute($image)
    {
        if ($image) {
            return asset(config('constant.path_upload_materials') . $image);
        } else {
            return asset(config('constant.default_image'));
        }
    }
}
