<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class MstroLinea extends Model
{
	protected $table      = 'mstro_lineas';
	protected $primaryKey = 'id_linea';
	public    $timestamps = false;

	protected $casts = [
		'orden_local' => 'int',
		'orden_web' => 'int',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'cod_linea',
		'nom_linea',
		'orden_local',
		'orden_web',
		'imagen',
		'slogan',
		'inactivo'
	];

	public function prdctos() {
		return $this->hasMany(Prdcto::class, 'id_linea');
	}

 

}
