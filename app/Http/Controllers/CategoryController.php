<?php

namespace App\Http\Controllers;

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
     * @param Category $category It is param input constructors
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request from client
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->category->create($request->all());
        return redirect()->route('categories.index');
    }
}
