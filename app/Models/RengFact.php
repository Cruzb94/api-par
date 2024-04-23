<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RengFact extends Model
{
    use HasFactory;

    protected $table = "reng_fac";

    public function factura()
	{
		return $this->belongsTo('App\Factura');
	}

 
}
