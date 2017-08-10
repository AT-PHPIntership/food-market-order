<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyMenu extends Model
{
    use softDeletes;

    /**
     * Enable created_at and updated_at behavior
     */
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_menus';
    protected $fillable = ['quantity', 'created_at', 'updated_at'];

    /**
     * Get the foods for the menu item.
     * @return relationship
     */
    public function food()
    {
        return $this->belongsTo('App\Food', 'food_id', 'id');
    }
}
