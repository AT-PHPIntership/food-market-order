<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
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
    public function __construct(Category $category)
    {
        $this->category = $category;
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
    public function update(CategoryRequest $request, $id)
    {
        $category =  $this->category->findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return view('categories.edit', ['category'=> $category]);
    }
}
