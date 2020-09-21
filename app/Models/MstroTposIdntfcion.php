<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 
class MstroTposIdntfcion extends Model
{
	protected $table = 'mstro_tpos_idntfcion';
	protected $primaryKey = 'id_idntfcion';
	public $timestamps = false;

	protected $casts = [
		'idsoenac' => 'int',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'cod_idntfcion',
		'cod_dian_idntfcion',
		'nom_idntfcion',
		'idsoenac',
		'inactivo'
	];
}
