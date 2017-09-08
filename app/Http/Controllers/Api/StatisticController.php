<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

		foreach($model_files as $model_file)
		{
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
}
