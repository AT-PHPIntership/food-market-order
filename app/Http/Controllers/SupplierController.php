<?php

namespace App\Http\Controllers;

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
}
