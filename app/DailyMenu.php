<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyMenu extends Model
{
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
     * Return all menu item in database with paginate by 10 item per page
     *
     * @return array Menu object
     */
    public static function getAll()
    {
        return DailyMenu::select('date')
                        ->orderBy('date', 'desc')
                        ->distinct()
                        ->get();
    }
}
