<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class MstroDneClsePrdcto extends Model
{
	protected $table = 'mstro_dne_clse_prdctos';
	protected $primaryKey = 'id_clse_dne_prdcto';
	public $timestamps = false;

	protected $casts = [
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nom_clse_dne_prdcto',
		'ciiu',
		'inactivo'
	];

	public function prdctos()
	{
		return $this->hasMany(Prdcto::class, 'id_clse_dne_prdcto');
	}
}
