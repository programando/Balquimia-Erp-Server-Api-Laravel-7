<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use DB;
use Cache;
class CarteraFactura extends Model
{
	protected $table      = 'cartera_facturas';
	protected $primaryKey = 'id_crtra';
	public    $timestamps = false;

	protected $casts = [
		'id_fact'     => 'int',				'plazo_fact'  => 'int',					'dias_hoy'    => 'int',				'vr_saldo'    => 'float',				
		'id_cliente'  => 'int',				'id_vendedor' => 'int'
	];

	protected $dates = [		'fcha_fact'	];

	protected $fillable = [			
		'prfjo',			'id_fact',			'fcha_fact',			'plazo_fact',			'dias_hoy',			'vr_saldo',			'id_cliente',			'id_vendedor',	'cod_vendedor'
	];

			// SCOPES
		//=========
			public function scopeClientesPorVendedor ( $query, $idTercVendedor ){
				 $nomCache            = 'ClientesPorVendedor'.$idTercVendedor ;
				 $ClientesPorVendedor = Cache::tags($nomCache)->remember($nomCache,60,   function(  )  use ($idTercVendedor)  {   
              return     DB::select(' call cartera_clientes_cxc_por_vendedor ( ?)', array($idTercVendedor));
        });
        return $ClientesPorVendedor ;
			}

			public function scopeFacturasPorNit( $query, $nitCliente ){
					return     DB::select(' call cartera_clientes_facturas_por_nit ( ?)', array( "$nitCliente"));
			}

			public function scopeTotalPorVendedor($query, $idTercVendedor) {
				 $nomCache            = 'TotalPorVendedor'.$idTercVendedor ;
				 $TotalPorVendedor = Cache::tags($nomCache)->remember($nomCache,60,   function(  )  use ($idTercVendedor)  {   
              return     DB::select(' call cartera_clientes_facturas_por_id_vendedor ( ?)', array($idTercVendedor));
        });
        return $TotalPorVendedor ;
				
			}
			
}
