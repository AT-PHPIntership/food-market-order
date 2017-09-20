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
        $this->food->initQueryData(request()->all());
        $foods = $this->food->search()->withs()->paginate(Food::ITEMS_PER_PAGE);

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
        $withs = true;
        $food = $this->food->search($withs)->findOrFail($id);
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
        $this->food->setColumnsFilter([
            'id',
            'name',
            'category_id',
            'price',
            'image',
            'description'
        ]);
        $this->food->setColumnsCondition([
            'category_id' => $categoryId
        ]);
        $foods = $this->food->search()->paginate(Food::ITEMS_PER_PAGE);

        if ($foods) {
            return response()->json(collect(['success' => true])->merge($foods));
        }
        $error = __('Has error during access this page');

        return response()->json(['error' => $error]);
    }
}
