<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = "factura";
    protected $primaryKey = "fact_num";
    
    protected $fillable = [
    'fact_num',
      'contrib',
      'nombre',
      'rif',
      'nit',
      'num_control',
      'status',
      'comentario',
      'descrip',
      'saldo',
      'fec_emis',
      'fec_venc',
      'co_cli',
      'co_ven',
      'co_tran',
      'dir_ent',
      'forma_pag',
      'tot_bruto',
      'tot_neto',
      'glob_desc',
      'tot_reca',
      'porc_gdesc',
      'porc_reca',
      'total_uc',
      'total_cp',
      'tot_flete',
      'monto_dev',
      'totklu',
      'anulada',
      'impresa',
      'iva',
      'iva_dev',
      'feccom',
      'numcom',
      'tasa',
      'moneda',
      'dis_cen',
      'vuelto',
      'seriales',
      'tasag',
      'tasag10',
      'tasag20',
      'campo1',
      'campo2',
      'campo3',
      'campo4',
      'campo5',
      'campo6',
      'campo7',
      'campo8',
      'co_us_in',
      'fe_us_in',
      'co_us_mo',
      'fe_us_mo',
      'co_us_el',
      'fe_us_el',
      'revisado',
      'trasnfe',
      'numcon',
      'co_sucu',
      'rowguid',
      'mon_ilc',
      'otros1',
      'otros2',
      'otros3',
      'num_turno',
      'aux01',
      'aux02',
      'ID',
      'salestax',
      'origen',
      'origen_d',
      'sta_prod',
      'fec_reg',
      'impfis',
      'impfisfac',
      'imp_nro_z',
      'ven_ter',
      'ptovta',
      'telefono',
    ];
    
    public function reng_fact()
	{
		return $this->hasMany('App\RengFact');
	}
}
