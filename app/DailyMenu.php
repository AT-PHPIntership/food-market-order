<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyMenu extends Model
{
    use SoftDeletes;

    protected $timestamp = true;
    protected $dates = ['deleted_at'];
    /**
     * Enable created_at and updated_at behavior
     */
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_menus';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['quantity', 'created_at', 'updated_at'];

    /**
     * Get the food for the menu item.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function food()
    {
        return $this->belongsTo('App\Food', 'food_id', 'id');
    }
}
