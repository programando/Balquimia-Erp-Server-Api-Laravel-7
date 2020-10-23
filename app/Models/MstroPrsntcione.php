<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class MstroPrsntcione extends Model
{
	protected $table = 'mstro_prsntciones';
	protected $primaryKey = 'id_prsntcion';
	public $timestamps = false;

	protected $casts = [
		'capac_volum' => 'float',
		'cant_und_empque' => 'int',
		'web' => 'bool',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nom_prsntcion',
		'capac_volum',
		'cant_und_empque',
		'dscrpcion',
		'web',
		'inactivo'
	];

	public function prdctos_prsntciones()
	{
		return $this->hasMany(PrdctosPrsntcione::class, 'id_prsntcion');
	}
}
