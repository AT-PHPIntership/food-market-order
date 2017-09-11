<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Material;
use App\Food;
use App\OrderItem;

class StatisticController extends ApiController
{
    /**
     * Get count of resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function countResources()
    {
        $model_files = \File::files('../app/');

        foreach ($model_files as $model_file) {
            $fileName = \File::name($model_file);
            if ($fileName == 'OrderItem') {
                continue;
            }
            $modelName = 'App\\'.$fileName;
            $modelInstance = new $modelName;
            if ($fileName == 'DailyMenu') {
                $curDate = date('Y-m-d');
                $counts[$modelInstance->getTable()] = $modelInstance->where('date', '=', $curDate)->count();
                continue;
            }
            $counts[$modelInstance->getTable()] = $modelInstance->count();
        }

        return response()->json(collect(['data' => $counts])->merge(['success' => true]));
    }

    /**
     * Get top of order by table type
     *
     * @param string $tableType type of target table
     * @param string $tableName name of target table
     *
     * @return array
     */
    public function getTopOrderOf($tableType, $tableName)
    {
        $columns = [
            $tableName.'.id',
            $tableName.'.name',
            $tableName.'.category_id',
            $tableName.'.price',
            $tableName.'.image',
            $tableName.'.description',
            'count(*) as total_order'
        ];
        return OrderItem::selectRaw(implode(' ,', $columns))
                        ->join($tableName, $tableName.'.id', '=', 'itemtable_id')
                        ->groupBy(['itemtable_id', 'itemtable_type'])
                        ->where('itemtable_type', $tableType)
                        ->orderBy('total_order', 'desc')
                        ->take(5)
                        ->get();
    }

    /**
     * Get trends for foods and materials
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrends()
    {
        $topFoods = $this->getTopOrderOf('App\\Food', 'foods');
        $topMaterials = $this->getTopOrderOf('App\\Material', 'materials');
        return response()->json(collect([
                            'foods' => $topFoods,
                            'materials' => $topMaterials
                        ])->merge(['success' => true]));
    }
}
