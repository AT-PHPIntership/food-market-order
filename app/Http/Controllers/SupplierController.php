<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Variable common object Supplier
     *
     * @var Supplier $Supplier
     */
    private $supplier;
    /**
     * SupplierController constructor.
     *
     * @param Supplier $Supplier It is param input constructors
     */
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request from client
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $this->supplier->create($request->all());
        return redirect()->route('categories.index');
    }
}
