<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Food;
use App\Http\Controllers\Controller;

class FoodController extends ApiController
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
        $columns = [
            'id',
            'name',
            'category_id',
            'price',
            'image',
            'description'
        ];
        $with['category'] = function ($query) {
            $query->select('id', 'name');
        };
        $foods = $this->food->select($columns)->with($with)->paginate(Food::ITEMS_PER_PAGE);

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
        $food = $this->food->select('id', 'name', 'price', 'description', 'category_id', 'image')->with(['category' => function ($query) {
            $query->select('id', 'name');
        }])->findOrFail($id);

        return response()->json($food, Response::HTTP_OK);
    }
}
