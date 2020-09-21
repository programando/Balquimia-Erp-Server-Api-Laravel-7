<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class MstroTposPrdcto extends Model
{
	protected $table = 'mstro_tpos_prdctos';
	protected $primaryKey = 'id_tpo_prdcto';
	public $timestamps = false;

	protected $casts = [
		'web' => 'bool',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'cod_tpo_prdcto',
		'nom_tpo_prdctos',
		'web',
		'inactivo'
	];

	public function prdctos()
	{
		return $this->hasMany(Prdcto::class, 'id_tpo_prdcto');
	}
}
