<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Supplier;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $suppliers = $this->supplier->search()->paginate(Supplier::ITEMS_PER_PAGE);
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
     * @param SupplierRequest $request Request from client
     * @param int             $id      It is id of supplier need update
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
        return redirect()->route('suppliers.edit', $id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id It is supplier id want delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $supplier = $this->supplier->findOrFail($id);
            if ($supplier->delete()) {
                flash(__('Delete Supplier Success'))->success()->important();
            } else {
                flash(__('Delete Supplier Errors!'))->error()->important();
            }
        } catch (ModelNotFoundException $ex) {
            flash(__('Supplier Not Found!'))->error()->important();
        }

        return redirect()->route('suppliers.index');
    }
}
