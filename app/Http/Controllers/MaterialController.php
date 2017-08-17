<?php

namespace App\Http\Controllers;

use App\Material;
use App\Category;
use App\Supplier;
use Image;
use Storage;
use App\Http\Requests\MaterialCreateRequest;

class MaterialController extends Controller
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
        $materials = $this->material->with(['category' => function ($query) {
            $query->select('id', 'name');
        }])->with(['supplier' => function ($query) {
            $query->select('id', 'name');
        }])->paginate(Material::ROWS_LIMIT);
        
        return view('materials.index', ['materials' => $materials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('materials.create', ['categories' => $categories, 'suppliers' => $suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MaterialCreateRequest $request request create material
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MaterialCreateRequest $request)
    {
        $arrMaterials = $request->all();
        $arrMaterials = $request->except(['_token']);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            $arrMaterials['image'] = $fileName;
        } else {
            $arrMaterials['image'] = config('constant.default_image');
        }
        if ($this->material->create($arrMaterials)) {
            if ($request->hasFile('image')) {
                Image::make($file)->save(public_path(config('constant.path_upload_materials'). $fileName));
            }
            flash(__('Created Material Success'))->success()->important();
            return redirect()->route('materials.index');
        } else {
            flash(__('Create Material Error'))->error()->important();
            return redirect()->back();
        }
    }
}
