<?php
namespace App;

use App\Libraries\Traits\AjaxSearchable;
use App\Libraries\Traits\SearchAndRelationShip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use SearchAndRelationShip;
    use ajaxSearchable;
    use softDeletes;

    const ITEMS_PER_PAGE = 10;
    
    protected $table = "foods";

    protected $fillable = ['id', 'name', 'category_id', 'price', 'description','image'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [

        'columns' => [
            'categories' => ['name', 'description'],
            'name',
            'description',
            'price',
        ],
        'joins' => [
            'categories' => ['category_id' => 'id']
        ]
    ];

    protected $withRelations = [
        'category' => ['id', 'name']
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $ajaxSearchable = [

        'columns' => [
            'foods.name',
            'foods.category_id'
        ]
    ];

    /**
     * Food has many order item
     *
     * @return mixed
     */
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'itemtable');
    }
    
    /**
     * Get the category for the food.
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
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
            return asset(config('constant.path_upload_foods') . $image);
        } else {
            return asset(config('constant.default_image'));
        }
    }
}
