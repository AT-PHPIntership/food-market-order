<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\Category;
use App\Supplier;

class MaterialController extends Controller
{
    protected $material;
    
    /**
     * MaterialController constructor.
     *
     * @param Materials $material dependence injection
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
        $materials = $this->material->search()->paginate(Material::ITEMS_PER_PAGE);
        
        return view('materials.index', ['materials' => $materials]);
    }
}
