<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class MstroClasesPrdcto extends Model
{
	protected $table = 'mstro_clases_prdcto';
	protected $primaryKey = 'id_clse_prdcto';
	public $timestamps = false;

	protected $casts = [
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nom_clse_prdcto',
		'inactivo'
	];

	public function prdctos()
	{
		return $this->hasMany(Prdcto::class, 'id_clse_prdcto');
	}
}
