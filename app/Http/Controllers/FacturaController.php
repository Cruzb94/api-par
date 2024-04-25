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
        ->limit(500)
    //    ->where('factura.fec_emis', '2023-11-02 00:00:00')
        ->select('reng_fac.fact_num', 'sub_lin.subl_des', 'reng_fac.total_art as kg')
        ->groupBy('sub_lin.subl_des', 'reng_fac.fact_num', 'reng_fac.total_art')
        ->orderBy('sub_lin.subl_des')
        ->get();
        
        $facturas_lacteos = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->where('lin_art.lin_des', 'LACTEOS')
        ->where('reng_fac.uni_venta', 'KG')
        ->limit(500)
    //    ->where('factura.fec_emis', '2023-11-02 00:00:00')
        ->select('reng_fac.fact_num', 'lin_art.lin_des', 'reng_fac.total_art as kg')
        ->groupBy('lin_art.lin_des', 'reng_fac.fact_num', 'reng_fac.total_art')
        ->orderBy('lin_art.lin_des')
        ->get();

        $facturas_embutidos = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->where('lin_art.lin_des', 'EMBUTIDOS')
        ->where('reng_fac.uni_venta', 'KG')
        ->limit(500)
    //    ->where('factura.fec_emis', '2023-11-02 00:00:00')
        ->select('reng_fac.fact_num', 'lin_art.lin_des', 'reng_fac.total_art as kg')
        ->groupBy('lin_art.lin_des', 'reng_fac.fact_num', 'reng_fac.total_art')
        ->orderBy('lin_art.lin_des')
        ->get();

        $total_pollo = [];
        $total_carne = [];
        $total_cerdo = [];
        $total_lacteos = [];
        $total_embutidos = [];

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

        foreach($facturas_lacteos as $lacteos) {
            if($lacteos->kg[0] == '.') {
                array_push($total_lacteos, '0'.$lacteos->kg);
            } else {
                array_push($total_lacteos, $lacteos->kg);
            }
          
        } 

        foreach($facturas_embutidos as $embutidos) {
            if($embutidos->kg[0] == '.') {
                array_push($total_embutidos, '0'.$embutidos->kg);
            } else {
                array_push($total_embutidos, $embutidos->kg);
            }
          
        } 

        return response()->json([
            'status' => true,
            'total_pollo_kg' => array_sum($total_pollo),
            'total_carne_kg' => array_sum($total_carne),
            'total_cerdo_kg' => array_sum($total_cerdo),
            'total_lacteos_kg' => array_sum($total_lacteos),
            'total_embutidos_kg' => array_sum($total_embutidos),
        ]);
    }

    public function topBuyClients() {
        $results = DB::table('factura')
        ->join('clientes', 'factura.co_cli', '=', 'clientes.co_cli')
        ->limit(200)
        ->select(
        DB::raw('SUM(tot_neto) AS total_neto_compras'),
        DB::raw('clientes.cli_des AS cliente'))
        ->groupBy('clientes.cli_des')
        ->orderBy('total_neto_compras', 'desc')
        ->get(); 

        return response()->json([
            'status' => true,
            'results' => $results
        ]);
    }

    public function topBuyArticles() {
        $results = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->limit(200)
        ->select(
        DB::raw('sum(reng_fac.total_art) as total_vendidos'),
        DB::raw('art.art_des'))
        ->groupBy('art.art_des')
        ->orderBy('total_vendidos', 'desc')
        ->get(); 

        return response()->json([
            'status' => true,
            'results' => $results
        ]);

    }
}
