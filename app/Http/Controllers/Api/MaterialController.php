<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Material;

class MaterialController extends ApiController
{
    /**
     * The Material implementation.
     *
     * @var Material
     */
    protected $material;

    /**
     * Create a new controller instance.
     *
     * @param Material $material instance of Food
     *
     * @return void
     */
    public function __construct(Material $material)
    {
        $this->material = $material;
    }

    /**
     * Display the list material by category id.
     *
     * @param integer $categoryId The categoryId to get materials
     *
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId)
    {
        $columns = [
            'id',
            'name',
            'category_id',
            'price',
            'image',
            'description'
        ];
        $materials = $this->material->select($columns)
                                    ->where('category_id', $categoryId)
                                    ->paginate($this->material->ITEMS_PER_PAGE);

        if ($materials) {
            return response()->json(collect(['success' => true])->merge($materials));
        }
        $error = __('Has error during access this page');

        return response()->json(['error' => $error]);
    }
}
