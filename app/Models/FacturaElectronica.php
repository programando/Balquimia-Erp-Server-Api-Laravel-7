<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class FacturaElectronica extends Model
{
    public $timestamps    = false;
    protected $primaryKey = 'id_fact_elctrnca';
    protected $table      ='fact_01_enc';
    
 

}
