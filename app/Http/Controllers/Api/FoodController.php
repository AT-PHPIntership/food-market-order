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

    /**
     * Get list foods in cart.
     *
     * @param \Illuminate\Http\Request $request request get cart
     *
     * @return \Illuminate\Http\Response
     */
    public function getCart(Request $request)
    {
        $foods = $this->food->whereIn('id', $request->all())->get();
        return response()->json([
            'data' => $foods,
            'success' => true
        ], Response::HTTP_OK);
    }
}
