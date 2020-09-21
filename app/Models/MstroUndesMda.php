<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class MstroUndesMda extends Model
{
	protected $table = 'mstro_undes_mda';
	protected $primaryKey = 'id_und_mda';
	public $timestamps = false;

	protected $casts = [
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'cod_und_mda',
		'nom_und_mda',
		'equiv_dane',
		'inactivo'
	];

	public function prdctos()
	{
		return $this->hasMany(Prdcto::class, 'id_und_mda');
	}
}
