<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Food;
use App\Category;

class FoodController extends Controller
{
    protected $food;

    /**
     * [__construct description]
     * @param Food $food [description]
     */
    public function __construct(Food $food)
    {
        $this->food = $food;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = $this->food->categories()->paginate(10);
        return view('foods.index', ['foods' => $foods]);
    }
}
