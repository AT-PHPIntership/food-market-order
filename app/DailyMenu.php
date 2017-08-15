<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyMenu extends Model
{
    use softDeletes;
    const ITEMS_PER_PAGE = 10;

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
}
