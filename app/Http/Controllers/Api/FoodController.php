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
     * Display the list food by category id.
     *
     * @param integer $categoryId The categoryId to get foods
     *
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId)
    {
        $error = __('Has error during access this page');
        
        if ($foods = $this->food->select('id', 'name', 'price', 'description')
                                ->where('category_id', $categoryId)
                                ->paginate($this->food->ITEMS_PER_PAGE)
        ) {
            return response()->json(collect(['success' => true])->merge($foods));
        }
        return response()->json(['error' => $error]);
    }
}
