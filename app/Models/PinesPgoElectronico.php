<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PinesPgoElectronico extends Model
{
	protected $table      = 'pines_pgo_electronico';
	protected $primaryKey = 'idregistro';
	public    $timestamps = false;

	protected $casts = [
		'idregistro'      => 'int',
		'idtercero_usrio' => 'int',
		'idtercero'       => 'int',
		'idpedido'        => 'int',
		'IdCtrLFactura'   => 'int',
		'idreg_contable'  => 'int',
		'valor_pin'       => 'float'
	];

	protected $dates = [
		'fecha_pin',
	];

	protected $fillable = [	'valor_pin', 'nro_pin' ];

			public function scopeBuscarPin( $query, $nro_pin) {  
				return     DB::select(' call pines_pago_electronico_buscar_pin ( ?)', array("$nro_pin"));
			}

			public function scopeBuscarPedido( $query, $id_ped) {  
				return     DB::select(' call pines_pago_electronico_buscar_pedido ( ?)', array($id_ped));
			}

			public function scopeBuscarFactura( $query, $prfjo_rslcion, $num_fact) {  
				return     DB::select(' call pines_pago_electronico_buscar_factura ( ?, ?)', array("$prfjo_rslcion", $num_fact));
			}
 
			public function getNomFullAttribute( $value) {
					return trim($value);
			}

			public function getEmailAttribute( $value ) {
					return trim($value);
			}
	}
