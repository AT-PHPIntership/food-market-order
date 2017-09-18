<?php

namespace App\Http\Controllers\Api;

use App\Material;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Food;

class CartController extends ApiController
{
    /**
     * The Food implementation.
     *
     * @var Food
     */
    protected $food;

    /**
     * The Material implementation.
     *
     * @var Material
     */
    protected $material;

    /**
     * Create a new controller instance.
     *
     * @param Food     $food     instance of Food
     * @param Material $material instance of Food
     *
     * @return void
     */
    public function __construct(Food $food, Material $material)
    {
        $this->food = $food;
        $this->material = $material;
    }

    /**
     * Get list foods in cart.
     *
     * @param \Illuminate\Http\Request $request request get cart
     *
     * @return \Illuminate\Http\Response
     */
    public function getCartFoods(Request $request)
    {
        $foods = $this->food->whereIn('id', $request->all())->get();
        return response()->json([
            'data' => $foods,
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * Get list materials in cart.
     *
     * @param \Illuminate\Http\Request $request request get cart
     *
     * @return \Illuminate\Http\Response
     */
    public function getCartMaterials(Request $request)
    {
        $material = $this->material->whereIn('id', $request->all())->get();
        return response()->json([
            'data' => $material,
            'success' => true
        ], Response::HTTP_OK);
    }
}
