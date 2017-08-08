<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Food;
use App\Category;
use App\Http\Requests\FoodRequest;

class FoodController extends Controller
{
    protected $foods;
    
    /**
     * FoodController constructor.
     *
     * @param Food $foods dependence injection
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryName = Category::orderBy('id', 'ASC')->get();
        return view('foods.create', ['categoryName' => $categoryName]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request of food
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FoodRequest $request)
    {
        $food = new Food;
        $food->name = $request->name;
        $food->category_id = $request->category_id;
        $food->description = $request->description;
        $food->price = $request->price;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $nameFile = time()."-".$name;
            $file->move("images/foods/", $nameFile);
            $food->image = $nameFile;
        } else {
            $food->image = 'no-images.png';
        }
        $result = $food ->save();
        if ($result) {
            Session::flash('message', trans('foods/createfood.create_food_susscess'));
            return redirect()->route('foods.edit');
        } else {
            Session::flash('message', trans('foods/createfood.create_food_error'));
            return redirect()->route('foods.create');
        }
    }
}
