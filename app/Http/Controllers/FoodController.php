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
        return view('foods.index', ['foods' => $foods]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id of food
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food = $this->food->findOrFail($id);
        return view('foods.show', ['food' => $food]);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param int $id It is id of food want to delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->food->findOrFail($id)->delete()) {
            flash(__('Delete Food Success'))->success()->important();
        } else {
            flash(__('Delete Food Error'))->error()->important();
        }
        return redirect()->route('foods.index');
    }
}
