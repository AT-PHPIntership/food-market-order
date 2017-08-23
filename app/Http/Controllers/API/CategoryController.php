<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    /**
     * The Category implementation.
     *
     * @var Category
     */
    protected $category;

    /**
     * Create a new controller instance.
     *
     * @param Category $category instance of Category
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->search()->paginate($this->category->ITEMS_PER_PAGE);
        return response()->json(['data' => $categories], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id of category
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->category->findOrFail($id);
        return response()->json($category);
    }
}
