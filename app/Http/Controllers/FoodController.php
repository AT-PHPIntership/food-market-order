<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;
use App\Category;
use App\Http\Requests\FoodPostRequest;
use Image;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('foods.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request of food
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FoodPostRequest $request)
    {
        $arrFoods = $request->all();
        $arrFoods = $request->except(['_token']);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            $arrFoods['image'] = $fileName;
        } else {
            $arrFoods['image'] = 'default.jpg';
        }
        if ($this->food->create($arrFoods)) {
            if ($request->hasFile('image')) {
                Image::make($file)->save(public_path(config('constant.path_upload_foods'). $fileName));
            }
            flash(__('Food Created'))->success()->important();
            return redirect()->route('foods.create');
        } else {
            flash(__('Create Food Error'))->error()->important();
            return redirect()->route('foods.create');
        }
    }
}
