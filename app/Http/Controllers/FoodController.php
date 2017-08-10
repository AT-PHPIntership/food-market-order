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
        // $food = $this->food->findOrFail($id);
        // $arrFoods = $request->all();
        // $arrFoods = $request->except('_method', '_token');
        // $arrFoods['image'] = $this->getImageFileName($request);
        // if ($food->update($arrFoods)) {
        //     // Image::make($file)->save(public_path('images/foods/' . $arrFoods['image']));
        //     // $this->storageImage($request->file('image'), $arrFoods['image']);
        //     // $request->file('picture_path')->move(config('constant.path_upload_news'), $news ->picture_path);
        //     $arrFoods['image']->file('image')->move('images/foods/', $arrFoods['image']);
        //     return redirect()->route('foods.edit', $id);
        // } else {
        //     flash(__('Update Error'))->error->important();
        //     return redirect()->route('foods.edit', $id);
        // }
        // $news = News::findOrFail($id);
        // $picturePathOld = $news['picture_path'];
        // $news ->user_id = $news->user->id;
        // $news->fill($request->all());
        // if ($request->hasFile('picture_path')) {
        //     $news ->picture_path= $request->picture_path->hashName();
        //     $request->file('picture_path')->move(config('constant.path_upload_news'), $news ->picture_path);
        //     unlink(config('constant.path_upload_news').$picturePathOld);
        // }
        // $result= $news->update();
        $food = $this->food->findOrFail($id);
        $arrFoods = $request->all;
        $arrFoods = $request->except('_method', '_token');
        if ($request->hasFile('image')) {
            $arrFoods['images'] = $request->image;
            $request->file('image')->move('images/foods/', $arrFoods['images']);
        }
        if ($food->update()) {
            dd($arrFoods);
        }
    }

     /**
     * Get filename from request
     *
     * @param Request $request the request need to get file name
     *
     * @return string
     */
    public function getImageFileName(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
        } else {
            $fileName = 'default.jpg';
        }
        return $fileName;
    }

    /**
     * Save image file to public/image/foods
     *
     * @param File   $file     image file
     * @param string $fileName the name to storage
     *
     * @return void
     */
    public function storageImage(File $file, $fileName)
    {
        if (isset($file)) {
            Image::make($file)->save(public_path('images/foods/' . $fileName));
        }
    }
}
