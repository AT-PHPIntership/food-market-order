<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Food;

class FoodController extends Controller
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
     * Display the list food by category id.
     *
     * @param integer $categoryId The categoryId to get foods
     *
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId)
    {
        $error = __('Has error during access this page');
        
        if ($foods = $this->food->where('category_id', $categoryId)
        						->paginate($this->food->ITEMS_PER_PAGE)
        ) {
            return response()->json(['data' => $foods], Response::HTTP_OK);
        }
        return response()->json(['error' => $error], Response::HTTP_NOT_FOUND);
    }
}
