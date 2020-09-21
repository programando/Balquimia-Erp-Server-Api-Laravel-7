<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class MstroPuc extends Model
{
	protected $table = 'mstro_puc';
	protected $primaryKey = 'id_cnta';
	public $timestamps = false;

	protected $fillable = [
		'cod_cnta',
		'nom_cnta'
	];

	public function prdctos()
	{
		return $this->hasMany(Prdcto::class, 'id_cnta_vta');
	}
}
