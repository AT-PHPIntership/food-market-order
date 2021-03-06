<?php

namespace App;

use App\Libraries\Traits\SearchAndRelationShip;
use App\Libraries\Traits\Deletable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SearchAndRelationShip;
    use Deletable;
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
        'columns' => [
            'categories' => ['name', 'description'],
            'suppliers'=> ['name', 'description'],
            'name',
            'description',
            'price'
        ],
        'joins' => [
            'categories' => ['category_id' => 'id'],
            'suppliers' => ['supplier_id' => 'id']
        ]
    ];

    protected $withRelations = [
        'category' => ['categories.id', 'categories.name'],
        'supplier' => ['suppliers.id', 'suppliers.name']
    ];

    /**
     * Relates model.
     *
     * @var array
     */
    protected $relates = [

        'relates' => [
            'orderItems'
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
