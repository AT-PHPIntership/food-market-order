<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Supplier;

class SupplierController extends Controller
{
    /**
     * Variable common object Supplier
     *
     * @var Supplier $supplier
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = $this->supplier->orderBy('id', 'DESC')->paginate(10);
        return view('suppliers.index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id It is id of supplier need update
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = $this->supplier->findOrFail($id);
        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SupplierRequest $request Request from client
     * @param int                                $id      It is id of supplier need update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        $supplier = $this->supplier->findOrFail($id);
        $supplier->update($request->all());
        if ($supplier) {
            flash(__('Update Supplier Success'))->success()->important();
        } else {
            flash(__('Update Supplier Errors'))->error()->important();
        }
        return back();
    }
}
