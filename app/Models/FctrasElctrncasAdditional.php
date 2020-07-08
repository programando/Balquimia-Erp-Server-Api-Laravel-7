<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasAdditional
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property string $dpto
 * @property string $frma_pgo
 * @property string $nro_tlfno
 * @property string $vr_letras
 * @property float $vr_base
 * @property float $pctje_iva
 * @property float $vr_iva
 * 
 * @property FctrasElctrnca $fctras_elctrnca
 *
 * @package App\Models
 */
class FctrasElctrncasAdditional extends Model
{
	protected $table = 'fctras_elctrncas_additionals';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'vr_base' => 'float',
		'pctje_iva' => 'float',
		'vr_iva' => 'float'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'dpto',
		'frma_pgo',
		'nro_tlfno',
		'vr_letras',
		'vr_base',
		'pctje_iva',
		'vr_iva'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}

	public function getVrLetrasAttribute ( $value ){
		return trim ( $value );
	}
	
}
