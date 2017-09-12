<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
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
     *
     * @return void
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
        $columns = [
            'foods.id',
            'foods.name',
            'foods.category_id',
            'foods.price',
            'foods.image',
            'foods.description'
        ];
        $foods = $this->food->search()->select($columns)->paginate(Food::ITEMS_PER_PAGE);

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
        $food = $this->food->search()->findOrFail($id);

        return response()->json($food, Response::HTTP_OK);
    }
}
