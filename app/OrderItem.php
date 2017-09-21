<?php

namespace App;

use App\Libraries\Traits\SearchAndRelationShip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    use SearchAndRelationShip;
    use softDeletes;

    const TREND_ITEMS = 5;

    protected $fillable = ['id', 'itemtable_id', 'order_id', 'itemtable_type', 'quantity'];

    /**
     * Material has many order items
     *
     * @return mixed
     */
    public function itemtable()
    {
        return $this->morphTo();
    }

    /**
     * OrderItem has one Order
     *
     * @return mixed
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get top of order by model
     *
     * @param string $tableType type of target table
     *
     * @return array
     */
    public function getTrendOrderByModel($tableType)
    {
        $modelInstance = new $tableType;
        $tableName = $modelInstance->getTable();
        $columns = [
            $tableName.'.id',
            $tableName.'.name',
            $tableName.'.category_id',
            $tableName.'.price',
            $tableName.'.image',
            $tableName.'.description',
            DB::raw('count(*) as total_order')
        ];
        return self::select($columns)
                    ->join($tableName, $tableName.'.id', '=', 'itemtable_id')
                    ->groupBy(['itemtable_id', 'itemtable_type'])
                    ->where('itemtable_type', $tableType)
                    ->orderBy('total_order', 'desc')
                    ->take(self::TREND_ITEMS)
                    ->get();
    }
}
