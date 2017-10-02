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
        $this->material->setColumnsFilter([
            'materials' => [
                'id',
                'name',
                'category_id',
                'supplier_id',
                'price',
                'image',
                'description',
                'status'
            ]
        ]);
        $this->material->initQueryData(request()->all());
        $materials = $this->material->search()->withs()->paginate(isset(request()->get('size')) ? request()->get('size') : Material::ITEMS_PER_PAGE);

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
        $material = $this->material->withs()->findOrFail($id);
        return response()->json($material, Response::HTTP_OK);
    }
}
