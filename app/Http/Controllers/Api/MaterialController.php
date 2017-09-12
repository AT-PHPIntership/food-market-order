<?php

namespace App\Http\Controllers\Api;

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
        $withs = $filters = $orders = true;

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

        $this->material->setColumnsFilter(request()->only(['category_id', 'supplier_id', 'status']));
        $this->material->setColumnsOrder(request()->only(['created_at', 'name', 'price']));
        $materials = $this->material->search($withs, $filters, $orders)->select($columns)->paginate(Material::ITEMS_PER_PAGE);

        return response()->json($materials, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param Integer $id of material
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $withs = true;
        $material = $this->material->search($withs)->findOrFail($id);
        return response()->json($material, Response::HTTP_OK);
    }
}
