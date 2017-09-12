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
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request create
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $request;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id id material
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $material = $this->material->search()->findOrFail($id);

        return response()->json($material, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id material
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request update
     * @param int                      $id      id material update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = $request;
        $id = $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id id delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = $id;
    }
}
