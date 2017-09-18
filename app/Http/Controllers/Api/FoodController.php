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

    /**
     * Display the list food by category id.
     *
     * @param integer $categoryId The categoryId to get foods
     *
     * @return \Illuminate\Http\Response
     */
    public function showBy($categoryId)
    {
        $columns = [
            'id',
            'name',
            'category_id',
            'price',
            'image',
            'description'
        ];
        $foods = $this->food->select($columns)
                            ->where('category_id', $categoryId)
                            ->paginate($this->food->ITEMS_PER_PAGE);
        if ($foods) {
            return response()->json(collect(['success' => true])->merge($foods));
        }
        $error = __('Has error during access this page');

        return response()->json(['error' => $error]);
    }
}
