<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyMenu extends Model
{
    use SoftDeletes;

    protected $timestamp = true;
    protected $dates = ['deleted_at'];
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
        return self::select('date')
                    ->orderBy('date', 'desc')
                    ->distinct()
                    ->get();
    }

    /**
     * Get a daily menu in storage according to $date
     *
     * @param string $date The date to get menu
     *
     * @return array  Menu object
     */
    public static function getMenu(string $date)
    {
        return self::join('foods', 'food_id', '=', 'foods.id')
                    ->join('categories', 'foods.category_id', '=', 'categories.id')
                    ->select(
                        'foods.id as food_id',
                        'foods.name as food_name',
                        'categories.name as category_name',
                        'foods.price as food_price',
                        'daily_menus.*'
                    )->where('date', $date)
                    ->get();
    }

    /**
     * Delete a menu item in database
     *
     * @param int $id The id to find and delete
     *
     * @return bool
     */
    public static function deleteMenuItem($id)
    {
        return self::where('id', $id)->delete();
    }
}
