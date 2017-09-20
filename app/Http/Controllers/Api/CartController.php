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
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request request refresh cart
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $foodIds = explode(',', $request->input('foods'));
        $materialIds = explode(',', $request->input('materials'));
        $foods = $this->food
            ->select(['id', 'name', 'price', 'image'])
            ->whereIn('id', $foodIds)->get();
        $materials = $this->material
            ->select(['id', 'name', 'price', 'image'])
            ->whereIn('id', $materialIds)->get();
        return response()->json([
            'data' => [
                'foods' => $foods,
                'materials' => $materials
            ],
            'success' => true
        ], Response::HTTP_OK);
    }
}
