<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Food;
use App\Category;

class FoodController extends Controller
{
    protected $foods;
    /**
     * [__construct ]
     *
     * @param Food $foods [call Model Food]
     */
    public function __construct(Food $foods)
    {
        $this->foods = $foods;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = $this->foods->paginate(10);
        return view('foods.index', ['foods'=>$foods]);
    }
}
