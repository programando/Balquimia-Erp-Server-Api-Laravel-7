<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class PrdctosPrsntcione extends Model
{
	protected $table = 'prdctos_prsntciones';
	protected $primaryKey = 'id_prdcto';
	public $timestamps = false;

	protected $casts = [
		'id_prdcto_ppal' => 'int',
		'id_prsntcion' => 'int',
		'costo' => 'float',
		'margen' => 'float',
		'prcntje_iva' => 'float',
		'vr_vta' => 'float',
		'vr_vta_web' => 'float',
		'peso_gr' => 'float',
		'peso_kg' => 'float',
		'dvsor_precio' => 'float',
		'en_lista_precios' => 'bool',
		'aplica_tron' => 'bool',
		'adm_kardex' => 'bool',
		'ver_web_balq' => 'bool',
		'ver_web_tron' => 'bool',
		'es_kit' => 'bool',
		'es_combo' => 'bool',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'id_prdcto_ppal',
		'id_prsntcion',
		'frgncia',
		'costo',
		'margen',
		'prcntje_iva',
		'vr_vta',
		'vr_vta_web',
		'peso_gr',
		'peso_kg',
		'dvsor_precio',
		'descrip_tron',
		'descrip_balq',
		'tags_bsqda',
		'en_lista_precios',
		'aplica_tron',
		'adm_kardex',
		'ver_web_balq',
		'ver_web_tron',
		'es_kit',
		'es_combo',
		'inactivo'
	];

	public function prdcto()
	{
		return $this->belongsTo(Prdcto::class, 'id_prdcto_ppal');
	}

	public function mstro_prsntcione()
	{
		return $this->belongsTo(MstroPrsntcione::class, 'id_prsntcion');
	}
}
