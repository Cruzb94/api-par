<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\RengFact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $facturas = DB::table('factura')->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')->select('factura.*', 'reng_fac.*')->where('factura.fact_num', 1)
      //  ->get();
       // $cantidad_kg_carne =  DB::select('SELECT * FROM users WHERE id > ?', [$userId]);
        return response()->json([
            'status' => true,
            'facturas' => $facturas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Product Created successfully!",
            'product' => $product
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if(!empty($product->id)) {

            return response()->json([
                'status' => true,
                'product' => $product
            ], Response::HTTP_OK); 
           
        } else {
            return response()->json([
                'status' => false,
                'message' => "product does not exist."
            ], Response::HTTP_OK);    
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->only("name"));

        return response()->json([
            'status' => true,
            'message' => "product updated successfully"
        ], Response::HTTP_OK); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Product::findOrFail($product->id)->delete();
        
        return response()->json([
            'status' => true,
            'message' => "product deleted successfully"
        ], Response::HTTP_OK); 
    }
}
