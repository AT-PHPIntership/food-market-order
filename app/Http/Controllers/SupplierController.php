<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Supplier;

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
     * @param Supplier $supplier It is param input constructors
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
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SupplierRequest $request Request from client
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        if ($this->supplier->create($request->all())) {
            flash(__('Create Supplier Success'))->success()->important();
            return redirect()->route('suppliers.index');
        } else {
            flash(__('Create Supplier Error'))->error()->important();
            return redirect()->route('suppliers.create');
        }
    }
}
