<?php
namespace App;

use App\Libraries\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use Searchable;
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
            'foods.name',
            'categories.name',
            'foods.description',
            'foods.price',
        ],
        'joins' => [
            'categories' => ['foods.category_id', 'categories.id']
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
