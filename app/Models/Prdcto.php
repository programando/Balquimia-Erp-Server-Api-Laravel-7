<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class Prdcto extends Model
{
	protected $table = 'prdctos';
	protected $primaryKey = 'id_prdcto_ppal';
	public $timestamps = false;

	protected $casts = [
		'id_cnta_vta' => 'int',
		'id_cnta_inv' => 'int',
		'id_cnta_costo' => 'int',
		'id_tpo_prdcto' => 'int',
		'id_clse_dne_prdcto' => 'int',
		'id_und_mda' => 'int',
		'id_clse_prdcto' => 'int',
		'id_linea' => 'int',
		'dnsdad' => 'float',
		'mp_fbrcda' => 'bool',
		'mp_ctrlda' => 'bool',
		'prstmo' => 'bool',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'clave',
		'id_cnta_vta',
		'id_cnta_inv',
		'id_cnta_costo',
		'id_tpo_prdcto',
		'id_clse_dne_prdcto',
		'id_und_mda',
		'id_clse_prdcto',
		'id_linea',
		'nom_prdcto',
		'nom_fctrcion',
		'tpo_dspcho',
		'dnsdad',
		'mp_fbrcda',
		'mp_ctrlda',
		'prstmo',
		'inactivo'
	];

	public function mstro_dne_clse_prdcto()
	{
		return $this->belongsTo(MstroDneClsePrdcto::class, 'id_clse_dne_prdcto');
	}

	public function mstro_clases_prdcto()
	{
		return $this->belongsTo(MstroClasesPrdcto::class, 'id_clse_prdcto');
	}

	public function mstro_tpos_prdcto()
	{
		return $this->belongsTo(MstroTposPrdcto::class, 'id_tpo_prdcto');
	}

	public function mstro_undes_mda()
	{
		return $this->belongsTo(MstroUndesMda::class, 'id_und_mda');
	}

	public function mstro_linea()
	{
		return $this->belongsTo(MstroLinea::class, 'id_linea');
	}

	public function mstro_puc()
	{
		return $this->belongsTo(MstroPuc::class, 'id_cnta_vta');
	}

	public function prdctos_prsntciones()
	{
		return $this->hasMany(PrdctosPrsntcione::class, 'id_prdcto_ppal');
	}
}
