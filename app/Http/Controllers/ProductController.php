<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=DB::table('tbl_product_detail')->get();

        foreach($products as $product) {
            // Convert time to dd/mm/yyyy
            $product->from_date = date('d/m/yy',strtotime($product->from_date));
            $product->end_date = date('d/m/yy', strtotime($product->end_date));
        }
        return view('admin.product.index', ['products' => $products]);
    }

    // Create a product
    public function createProduct() {
        $categories = DB::table('tbl_category')->get();


        return view('admin.product.create',['categories' => $categories]);
    }

    // Get product API
    public function getProductsApi() {

        // Get products
        $products=DB::table('tbl_product_detail')->get();

        foreach($products as $product) {
            // Convert time to dd/mm/yyyy
            $product->from_date = date('d/m/yy',strtotime($product->from_date));
            $product->end_date = date('d/m/yy', strtotime($product->end_date));
        }

        return response()->json($products);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
