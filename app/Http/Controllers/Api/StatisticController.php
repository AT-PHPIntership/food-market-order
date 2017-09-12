<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $modelFiles = \File::files('../app/');

        foreach ($modelFiles as $modelFile) {
            $fileName = \File::name($modelFile);
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
     *
     * @return array
     */
    public function getTopOrderOf($tableType)
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
        $topFoods = $this->getTopOrderOf('App\\Food');
        $topMaterials = $this->getTopOrderOf('App\\Material');

        if ($topFoods && $topMaterials) {
            return response()->json(collect([
                            'foods' => $topFoods,
                            'materials' => $topMaterials
                        ])->merge(['success' => true]));
        }
        $error = __('Has error during access this page');
        return response()->json(['error' => $error], Response::HTTP_NOT_FOUND);
    }
}
