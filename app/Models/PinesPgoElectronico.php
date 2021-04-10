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

			public function scopeBuscarPin( $query, $Nro_Pin) {  
				return     DB::select(' call pines_pago_electronico_buscar ( ?)', array("$Nro_Pin"));
			}

			public function getNomFullAttribute( $value) {
					return trim($value);
			}
	}
