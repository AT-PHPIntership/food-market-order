<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use softDeletes;
    
    protected $table = "foods";
    protected $fillable = ['id', 'name', 'category_id', 'price', 'description','image'];

    /**
     * Food has many order item
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'itemtable');
    }
    
    /**
     * Food has one Category
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
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
