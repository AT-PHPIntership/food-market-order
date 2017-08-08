<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Food;
use App\Category;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = DB::table('foods')
                ->join('categories', 'foods.category_id', '=', 'categories.id')
                ->select('foods.*', 'categories.name AS category_name')->orderBy('id', 'DESC')
                ->paginate(10);
        return view('foods.index', ['foods' => $foods]);
    }
}
