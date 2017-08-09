<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Food;
use App\Category;
use App\Http\Requests\FoodRequest;
use Image;

class FoodController extends Controller
{
    protected $food;
    
    /**
     * FoodController constructor.
     *
     * @param Food $foods dependence injection
     */
    public function __construct(Food $food)
    {
        $this->food = $food;
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
        //$food = new Food;
        // $food->name = $request->name;
        // $food->category_id = $request->category_id;
        // $food->description = $request->description;
        // $food->price = $request->price;
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $name = $file->getClientOriginalName();
        //     $nameFile = time()."-".$name;
        //     $file->move("images/foods/", $nameFile);
        //     $food->image = $nameFile;
        // } else {
        //     $food->image = 'no-images.png';
        // }
        // $result = $food ->save();
        // if ($result) {
        //     Session::flash('message', trans('foods/createfood.create_food_susscess'));
        //     return redirect()->route('foods.edit');
        // } else {
        //     Session::flash('message', trans('foods/createfood.create_food_error'));
        //     return redirect()->route('foods.create');
        // }
        // Person::create($request->except('_token'));
        $arr = $request->all();
        $arr = $request->except(['_token']);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            Image::make($file)->save(public_path('images/foods/'. $fileName));
            $arr['image'] = $fileName;
        } else {
            $arr['image'] = 'default.jpg';
        }
        if ($this->food->create($arr)) {
            flash(trans('creat.create_success'))->success();
        } else {
            flash(trans('creat.create_error'))->error();
        }
        // return redirect()->route('foods.index');
    }
}
