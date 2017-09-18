<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->search()->paginate(Category::ITEMS_PER_PAGE);
        return view('categories.index', ['categories' => $categories]);
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
     * @param CategoryRequest $request Request from client
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if ($this->category->create($request->all())) {
            flash(__('Create Category Success'))->success()->important();
            return redirect()->route('categories.index');
        } else {
            flash(__('Create Category Error'))->error()->important();
            return redirect()->route('categories.create');
        }
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
     * @param CategoryUpdateRequest $request Request from client
     * @param int                   $id      It is id of category need update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = $this->category->findOrFail($id);
        $category->update($request->all());
        if ($category) {
            flash(__('Update Category Success'))->success()->important();
        } else {
            flash(__('Update Category Errors'))->error()->important();
        }
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id It is category id want delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = $this->category->findOrFail($id);
            $result = $category->deletable();
            if ($result['message'] === true) {
                flash(__('Delete Category Success'))->success()->important();
            } else if ($result['message'] === false) {
                flash(__('Please make sure you deleted food and material items belong to this category before!'))->error()->important();
            } else {
                flash(__('Delete Category Errors'))->error()->important();
            }
        } catch (ModelNotFoundException $ex) {
            flash(__('Category Not Found!'))->error()->important();
        }

        return redirect()->route('categories.index');
    }
}
