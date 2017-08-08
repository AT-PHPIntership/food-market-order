<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Variable common object Category
     *
     * @var Category $category
     */
    private $category;

    /**
     * CategoryController constructor.
     *
     * @param Category $cate It is param input constructors
     */
    public function __construct(Category $cate)
    {
        $this->category = $cate;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id It is id of category need update
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->category->findOrFail($id);
        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request from client
     * @param int                      $id      It is id of category need update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories|max:255',
            'description' => 'required',
        ], [
            'name.required' => ' The category name field is required.',
            'name.max' => ' The category name may not be greater than 255 characters.',
            'name.unique' => ' The category name is existed.',
            'description.required' => ' The description field is required.',
        ]);
        $cate =  $this->category->findOrFail($id);
        $cate->name = $request->name;
        $cate->description = $request->description;
        $cate->save();
        return view('categories.edit', ['category'=> $cate]);
    }
}
