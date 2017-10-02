<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Food;

class FoodController extends ApiController
{
    /**
     * The Category implementation.
     *
     * @var Food
     */
    protected $food;

    /**
     * Create a new controller instance.
     *
     * @param Food $food instance of Food
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
        $this->food->setColumnsFilter([
            'foods' => [
                'id',
                'name',
                'category_id',
                'price',
                'image',
                'description'
            ]
        ]);
        $perPage = Food::ITEMS_PER_PAGE;
        if (request()->has('size')) {
            $perPage = request()->get('size') == null ? $perPage : request()->get('size');
        }
        $this->food->initQueryData(request()->all());
        $foods = $this->food->search()->withs()->paginate($perPage);

        return response()->json($foods, Response::HTTP_OK);
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
        $food = $this->food->withs()->findOrFail($id);
        return response()->json($food, Response::HTTP_OK);
    }
}
