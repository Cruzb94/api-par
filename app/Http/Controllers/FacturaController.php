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
        $facturas_pollo = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->join('sub_lin', 'lin_art.co_lin', '=', 'sub_lin.co_lin')
        ->where('lin_art.lin_des', 'CARNICERIA')
        ->where('sub_lin.subl_des', 'POLLO')
        ->where('reng_fac.uni_venta', 'KG')
        ->limit(100)
   //     ->where('factura.fec_emis', '2023-11-02 00:00:00')
        ->select('reng_fac.fact_num', 'sub_lin.subl_des', 'reng_fac.total_art as kg')
        ->groupBy('sub_lin.subl_des', 'reng_fac.fact_num', 'reng_fac.total_art')
        ->orderBy('sub_lin.subl_des')
        ->get();

        $facturas_carne = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->join('sub_lin', 'lin_art.co_lin', '=', 'sub_lin.co_lin')
        ->where('lin_art.lin_des', 'CARNICERIA')
        ->where('sub_lin.subl_des', 'CARNES')
        ->where('reng_fac.uni_venta', 'KG')
        ->limit(500)
    //    ->where('factura.fec_emis', '2023-11-02 00:00:00')
        ->select('reng_fac.fact_num', 'sub_lin.subl_des', 'reng_fac.total_art as kg')
        ->groupBy('sub_lin.subl_des', 'reng_fac.fact_num', 'reng_fac.total_art')
        ->orderBy('sub_lin.subl_des')
        ->get();

        
        $facturas_cerdo = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->join('sub_lin', 'lin_art.co_lin', '=', 'sub_lin.co_lin')
        ->where('lin_art.lin_des', 'CARNICERIA')
        ->where('sub_lin.subl_des', 'CERDO')
        ->where('reng_fac.uni_venta', 'KG')
        ->limit(1000)
    //    ->where('factura.fec_emis', '2023-11-02 00:00:00')
        ->select('reng_fac.fact_num', 'sub_lin.subl_des', 'reng_fac.total_art as kg')
        ->groupBy('sub_lin.subl_des', 'reng_fac.fact_num', 'reng_fac.total_art')
        ->orderBy('sub_lin.subl_des')
        ->get();
        
      $total_pollo = [];
      $total_carne = [];
      $total_cerdo = [];

        foreach($facturas_pollo as $pollo) {
            if($pollo->kg[0] == '.') {
                array_push($total_pollo, '0'.$pollo->kg);
            } else {
                array_push($total_pollo, $pollo->kg);
            }
          
        } 

        foreach($facturas_carne as $carne) {
            if($carne->kg[0] == '.') {
                array_push($total_carne, '0'.$carne->kg);
            } else {
                array_push($total_carne, $carne->kg);
            }
          
        } 

        foreach($facturas_cerdo as $cerdo) {
            if($cerdo->kg[0] == '.') {
                array_push($total_cerdo, '0'.$cerdo->kg);
            } else {
                array_push($total_cerdo, $cerdo->kg);
            }
          
        } 
       
       // ->sum('reng_fac.total_art');
       // $cantidad_kg_carne =  DB::select('SELECT * FROM users WHERE id > ?', [$userId]);
        return response()->json([
            'status' => true,
            'total_pollo_kg' => array_sum($total_pollo),
            'total_carne_kg' => array_sum($total_carne),
            'total_cerdo_kg' => array_sum($total_cerdo),
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
