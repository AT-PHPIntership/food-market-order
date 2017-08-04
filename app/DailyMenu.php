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
     * Return all menu item in database with paginate by 10 item per page
     *
     * @return array Menu object
     */
    public static function getAll()
    {
        return DB::table('daily_menus')
                            ->select('date')
                            ->orderBy('date', 'desc')
                            ->distinct()
                            ->get();
    }
}
