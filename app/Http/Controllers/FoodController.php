<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;

class FoodController extends Controller
{
    protected $food;
    
    /**
     * FoodController constructor.
     *
     * @param Food $food dependence injection
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
        $foods = $this->food->orderBy('id', 'DESC')->with('category')->paginate(10);
        return view('foods.index', ['foods'=>$foods]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id of food
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $food = Food::find($id);
        // $category = Category::find($food->category_id);
        // return view('admin.foods.show', ['food' => $food, 'category'=> $category]);
        $food = $this->food->findOrFail($id);
        return view('foods.show', ['food' => $food]);
    }
}
