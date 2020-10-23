<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class Prdcto extends Model
{
	protected $primaryKey   = 'id_prdcto_ppal';
	protected $table        = 'prdctos';
	public    $allowedSorts = ['nom_prdcto'];
	public    $timestamps   = false;
	public    $type         = 'productos';

	protected $casts = [
		'id_cnta_vta'        => 'int',			'id_cnta_inv'        => 'int',					'id_cnta_costo'      => 'int',					'id_tpo_prdcto'      => 'int',
		'id_clse_dne_prdcto' => 'int',			'id_und_mda'         => 'int',					'id_clse_prdcto'     => 'int',					'id_linea'           => 'int',
		'dnsdad'             => 'float',		'mp_fbrcda'          => 'bool',					'mp_ctrlda'          => 'bool',					'prstmo'             => 'bool',
		'inactivo'           => 'bool'
	];

	protected $fillable = [	'clave',			'id_cnta_vta',			'id_cnta_inv',			'id_cnta_costo',			'id_tpo_prdcto',			'id_clse_dne_prdcto',
													'id_und_mda',	'id_clse_prdcto',		'id_linea',					'nom_prdcto',					'nom_fctrcion',				'tpo_dspcho',
													'dnsdad',			'mp_fbrcda',				'mp_ctrlda',				'prstmo',								'inactivo'
	];

	public function fields(){
			return [
					'id'					 => $this->id_prdcto_ppal,
					'clave'			 => $this->clave,
					'nom_prdcto'        => $this->nom_prdcto,
			];
		}

		public function daneClaseProducto()	{
			return $this->belongsTo(MstroDneClsePrdcto::class, 'id_clse_dne_prdcto');
		}

		public function claseProducto()	{
			return $this->belongsTo(MstroClasesPrdcto::class, 'id_clse_prdcto');
		}

		public function tipoProducto()	{
			return $this->belongsTo(MstroTposPrdcto::class, 'id_tpo_prdcto');
		}

		public function unidadMedida()	{
			return $this->belongsTo(MstroUndesMda::class, 'id_und_mda');
		}

		public function linea()	{
			return $this->belongsTo(MstroLinea::class, 'id_linea');
		}

		public function puc()	{
			return $this->belongsTo(MstroPuc::class, 'id_cnta_vta');
		}

		public function presentaciones()	{
			return $this->hasMany(PrdctosPrsntcione::class, 'id_prdcto_ppal');
		}
		
}
