<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\RengFact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date_from = $_GET['date'];
        $facturas_pollo = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->join('sub_lin', 'lin_art.co_lin', '=', 'sub_lin.co_lin')
        //->where('lin_art.lin_des', 'CARNICERIA')
        ->where('sub_lin.subl_des', 'POLLO')
        ->where('reng_fac.uni_venta', 'KG')
        ->where('factura.fec_emis', $date_from. 'T00:00:00')
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
        ->select('reng_fac.fact_num', 'sub_lin.subl_des', 'reng_fac.total_art as kg')
        ->groupBy('sub_lin.subl_des', 'reng_fac.fact_num', 'reng_fac.total_art')
        ->orderBy('sub_lin.subl_des')
        ->get();

        $facturas_carne = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->join('sub_lin', 'lin_art.co_lin', '=', 'sub_lin.co_lin')
      //  ->where('lin_art.lin_des', 'CARNICERIA')
        ->where('sub_lin.subl_des', 'CARNES')
        ->where('reng_fac.uni_venta', 'KG')
        ->where('factura.fec_emis', $date_from. 'T00:00:00')
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
        ->select('reng_fac.fact_num', 'sub_lin.subl_des', 'reng_fac.total_art as kg')
        ->groupBy('sub_lin.subl_des', 'reng_fac.fact_num', 'reng_fac.total_art')
        ->orderBy('sub_lin.subl_des')
        ->get();

        
        $facturas_cerdo = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->join('sub_lin', 'lin_art.co_lin', '=', 'sub_lin.co_lin')
       // ->where('lin_art.lin_des', 'CARNICERIA')
        ->where('sub_lin.subl_des', 'CERDO')
        ->where('reng_fac.uni_venta', 'KG')
        ->where('factura.fec_emis', $date_from. 'T00:00:00')
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
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
        ->where('factura.fec_emis', $date_from. 'T00:00:00')
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
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
        ->where('factura.fec_emis', $date_from. 'T00:00:00')
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
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

        $date_from = $_GET['date'] . 'T00:00:00';

        $results = DB::table('factura')
        ->join('clientes', 'factura.co_cli', '=', 'clientes.co_cli')
        ->where('factura.fec_emis',  $date_from)    
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
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

        $date_from = $_GET['date'] . 'T00:00:00';
        $results = DB::table('factura')
        ->join('reng_fac', 'factura.fact_num', '=', 'reng_fac.fact_num')
        ->join('art', 'art.co_art', '=', 'reng_fac.co_art')
        ->join('lin_art', 'art.co_lin', '=', 'lin_art.co_lin')
        ->where('factura.fec_emis',  $date_from)    
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
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

    public function forWeek() {
        //$date_from = '2023-08-02', $date_to = "2023-08-16"
        $date_from = $_GET['date_from'];
        $date_to = $_GET['date_to'];
        $currentDate = Carbon::createFromFormat('Y-m-d', $date_from);
        $shippingDate = Carbon::createFromFormat('Y-m-d', $date_to);

        $diferencia_en_dias = $shippingDate->diffInDays($currentDate);
        $result = [];

        $porciones = explode("-", $date_from);
        $dia_mes = $porciones[2];

        $porciones_date_from = explode(" ", $date_from); 
        $porciones_date_to = explode(" ", $date_to); 

        $fecha = $porciones_date_from[0] . 'T00:00:00';
        $fecha_hasta = $porciones_date_to[0] . 'T00:00:00';
      // echo $fecha; die();
        
        $sub_query = DB::table('factura')
        ->where('factura.fec_emis', $fecha)    
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1)  
        ->select(
            DB::raw('factura.fact_num'), 
            DB::raw('count(fact_num) as total'), 
            DB::raw('DATEPART(HOUR, factura.fe_us_in) AS hora'))
        ->groupby('factura.fe_us_in', 'factura.fact_num');

        $main_query = DB::table($sub_query,'sub')->selectRaw("sub.hora, sum(sub.total) as total_facturas") 
        ->groupby('hora')
        ->orderBy('hora', 'asc')
        ->get(); 

        array_push($result, $main_query);

    
        for ($i=1; $i <= $diferencia_en_dias; $i++) { 

          $porciones_date_next = explode(" ", $currentDate->addDays(1)); 
        
           $sub_query = DB::table('factura')
            ->where('factura.fec_emis', $porciones_date_next[0].'T00:00:00')    
            ->where('factura.anulada', 0)  
            ->where('factura.impresa', 1)  
            ->select(
                DB::raw('factura.fact_num'), 
                DB::raw('count(fact_num) as total'), 
                DB::raw('DATEPART(HOUR, factura.fe_us_in) AS hora'))
            ->groupby('factura.fe_us_in', 'factura.fact_num');

            $main_query = DB::table($sub_query,'sub')->selectRaw("sub.hora, sum(sub.total) as total_facturas") 
            ->groupby('hora')
            ->orderBy('hora', 'asc')
            ->get(); 
                
            array_push($result, $main_query);  
    
         } 
        
        return response()->json([
            'status' => true,
            'results' => $result
        ]); 
    }

    public function forBox() {
        //$date_from = '2023-08-02', $date_to = "2023-08-16"
        $date_from = $_GET['date_from'];
        $date_to = $_GET['date_to'];
        $caja = $_GET['caja'];
        $currentDate = Carbon::createFromFormat('Y-m-d', $date_from);
        $shippingDate = Carbon::createFromFormat('Y-m-d', $date_to);

        $diferencia_en_dias = $shippingDate->diffInDays($currentDate);
        $result = [];

        $porciones = explode("-", $date_from);
        $dia_mes = $porciones[2];

        $porciones_date_from = explode(" ", $date_from); 

        $fecha = $porciones_date_from[0] . 'T00:00:00';
       //echo $fecha; die();
        
       if($caja !== '') {
        $sub_query = DB::table('factura')
        ->join('vendedor', 'factura.co_ven', '=', 'vendedor.co_ven')
        ->where('factura.fec_emis', $fecha)    
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1)  
    //    ->where('vendedor.tipo',  'C')    
        ->where('vendedor.co_ven',  $caja)   
        ->select(
            DB::raw('factura.fact_num'), 
            DB::raw('count(fact_num) as total'), 
            DB::raw('DATEPART(HOUR, factura.fe_us_in) AS hora'),
            DB::raw('vendedor.co_ven as caja')
            )
        ->groupby('factura.fe_us_in', 'factura.fact_num', 'vendedor.co_ven');

        $main_query = DB::table($sub_query,'sub')->selectRaw("sub.hora, sum(sub.total) as total_facturas, sub.caja") 
        ->groupby('hora', 'caja')
        ->orderBy('caja', 'asc')
        ->get(); 
    } else {
        $sub_query = DB::table('factura')
        ->join('vendedor', 'factura.co_ven', '=', 'vendedor.co_ven')
        ->where('factura.fec_emis', $fecha)    
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1)  
        //->where('vendedor.tipo',  'C')     
        ->select(
            DB::raw('factura.fact_num'), 
            DB::raw('count(fact_num) as total'), 
            DB::raw('DATEPART(HOUR, factura.fe_us_in) AS hora'),
            DB::raw('vendedor.co_ven as caja')
            )
        ->groupby('factura.fe_us_in', 'factura.fact_num', 'vendedor.co_ven');

        $main_query = DB::table($sub_query,'sub')->selectRaw("sub.hora, sum(sub.total) as total_facturas, sub.caja") 
        ->groupby('hora', 'caja')
        ->orderBy('caja', 'asc')
        ->get(); 
    }
        

        array_push($result, $main_query);
        
     
        for ($i=1; $i <= $diferencia_en_dias; $i++) { 

          $porciones_date_next = explode(" ", $currentDate->addDays(1)); 
          $fecha_next = $porciones_date_next[0] . 'T00:00:00';

          if($caja !== '') {
            $sub_query = DB::table('factura')
            ->join('vendedor', 'factura.co_ven', '=', 'vendedor.co_ven')
            ->where('factura.fec_emis',  $fecha_next)    
            ->where('factura.anulada', 0)  
            ->where('factura.impresa', 1)  
           // ->where('vendedor.tipo',  'C')    
            ->where('vendedor.co_ven',  $caja)   
            ->select(
                DB::raw('factura.fact_num'), 
                DB::raw('count(fact_num) as total'), 
                DB::raw('DATEPART(HOUR, factura.fe_us_in) AS hora'),
                DB::raw('vendedor.co_ven as caja')
                )
            ->groupby('factura.fe_us_in', 'factura.fact_num', 'vendedor.co_ven');
    
            $main_query = DB::table($sub_query,'sub')->selectRaw("sub.hora, sum(sub.total) as total_facturas, sub.caja") 
            ->groupby('hora', 'caja')
            ->orderBy('caja', 'asc')
            ->get(); 
              array_push($result, $main_query);  
          } else {
            $sub_query = DB::table('factura')
            ->join('vendedor', 'factura.co_ven', '=', 'vendedor.co_ven')
            ->where('factura.fec_emis',  $fecha_next)    
            ->where('factura.anulada', 0)  
            ->where('factura.impresa', 1)  
          //  ->where('vendedor.tipo',  'C')    
            ->select(
                DB::raw('factura.fact_num'), 
                DB::raw('count(fact_num) as total'), 
                DB::raw('DATEPART(HOUR, factura.fe_us_in) AS hora'),
                DB::raw('vendedor.co_ven as caja')
                )
            ->groupby('factura.fe_us_in', 'factura.fact_num', 'vendedor.co_ven');
    
            $main_query = DB::table($sub_query,'sub')->selectRaw("sub.hora, sum(sub.total) as total_facturas, sub.caja") 
            ->groupby('hora', 'caja')
            ->orderBy('caja', 'asc')
            ->get(); 
              array_push($result, $main_query);  
          }

         
    
         } 
        
        return response()->json([
            'status' => true,
            'results' => $result
        ]); 
    }

    public function percentageInvoice() {
        $date = $_GET['date'] . 'T00:00:00';

        $results_factura = DB::table('factura')
        ->where('factura.fec_emis',  $date)    
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
        ->where('factura.impfis', '<>',  '')    
        ->select(
            DB::raw('*'))
        ->get(); 

        $results_notas = DB::table('factura')
        ->where('factura.fec_emis',  $date)    
        ->where('factura.anulada', 0)  
        ->where('factura.impresa', 1) 
        ->where('factura.impfis', '=',  '')    
        ->select(
            DB::raw('*'))
        ->get(); 

        return response()->json([
            'status' => true,
            'facturas' => count($results_factura),
            'notas_entrega' => count($results_notas)
        ]);
    }
    
}
