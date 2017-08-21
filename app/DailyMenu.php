<?php

namespace App;

use App\Libraries\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyMenu extends Model
{
    use Searchable;
    use softDeletes;

    const ITEMS_PER_PAGE = 10;

    /**
     * Enable created_at and updated_at behavior
     */
    public $timestamps = true;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
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
    protected $fillable = ['date', 'food_id', 'quantity', 'created_at', 'updated_at'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [

        'columns' => [
            'date',
        ]
    ];

    /**
     * Get the foods for the menu item.
     *
     * @return mixed
     */
    public function food()
    {
        return $this->belongsTo('App\Food', 'food_id', 'id');
    }
}
