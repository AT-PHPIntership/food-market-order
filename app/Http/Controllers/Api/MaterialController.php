<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Material;
use Illuminate\Http\Response;
class MaterialController extends ApiController
{
    protected $material;

    /**
     * MaterialController constructor.
     *
     * @param Material $material dependence injection
     */
    public function __construct(Material $material)
    {
        $this->material = $material;
    }

    /**
     * The Material implementation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = [
            'materials.id',
            'materials.name',
            'materials.category_id',
            'materials.supplier_id',
            'materials.price',
            'materials.image',
            'materials.description',
            'materials.status'
        ];
        $materials = $this->material->search()->select($columns)->paginate(Material::ITEMS_PER_PAGE);

        return response()->json($materials, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param $id of material
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $material = $this->material->search()->findOrFail($id);

        return response()->json($material, Response::HTTP_OK);
    }
}
