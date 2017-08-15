<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FoodUpdateRequest;
use App\Food;
use App\Category;
use Image;
use Storage;
use App\Http\Requests\FoodCreateRequest;
use File;

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
        $foods = $this->food->with('category')->paginate(Food::ITEMS_PER_PAGE);
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
     * @param FoodCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FoodCreateRequest $request)
    {
        $arrFoods = $request->all();
        $arrFoods = $request->except(['_token']);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            $arrFoods['image'] = $fileName;
        } else {
            $arrFoods['image'] = config('constant.default_image');
        }
        if ($this->food->create($arrFoods)) {
            if ($request->hasFile('image')) {
                Image::make($file)->save(public_path(config('constant.path_upload_foods'). $fileName));
            }
            flash(__('Food Created'))->success()->important();
            return redirect()->route('foods.index');
        } else {
            flash(__('Create Food Error'))->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id of food
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $food = $this->food->findOrFail($id);
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('foods.edit', ['food' => $food, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FoodUpdateRequest $request  update food
     * @param $id id of food
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FoodUpdateRequest $request, $id)
    {
        
        $food = $this->food->findOrFail($id);
        $dataFood = $request->except('_method', '_token');
        $oldPathImage = $food->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            $dataFood['image'] = $fileName;
        }
        if ($food->update($dataFood)) {
            if ($request->hasFile('image')) {
                Image::make($file)->save(public_path(config('constant.path_upload_foods'). $fileName));
                File::delete($oldPathImage);
            }
            flash(__('Update Food Success'))->success()->important();
               return redirect()->route('foods.index');
        } else {
            flash(__('Update Food Error'))->error()->important();
            return redirect()->back();
        }
    }
}
