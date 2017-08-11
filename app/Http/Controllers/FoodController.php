<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FoodPutRequest;
use App\Food;
use App\Category;
use Image;
use Storage;

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request of foods
     * @param  int  $id of foods
     *
     * @return \Illuminate\Http\Response
     */
    public function update(FoodPutRequest $request, $id)
    {
        
        $food = $this->food->findOrFail($id);
        $arrFoods = $request->all;
        $arrFoods = $request->except('_method', '_token');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            $arrFoods['image'] = $fileName;
        }
        if ($food->update($arrFoods)) {
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
}
