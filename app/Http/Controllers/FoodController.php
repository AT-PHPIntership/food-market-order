<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;
use App\Category;
use App\Http\Requests\FoodPostRequest;
use Image;
use Session;

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
        $foods = $this->food->with('category')->paginate(10);
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
    public function store(FoodPostRequest $request)
    {
        $arrFoods = $request->all();
        $arrFoods = $request->except(['_token']);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            Image::make($file)->save(public_path(config('constant.path_upload_foods'). $fileName));
            $arrFoods['image'] = $fileName;
        } else {
            $arrFoods['image'] = 'default.jpg';
        }
        if ($this->food->create($arrFoods)) {
            Session::flash('success', __('Create Food Success'));
            return redirect()->route('foods.index');
        } else {
            Session::flash('error', __('Create Food Error'));
            return redirect()->route('foods.create');
        }
    }
}
