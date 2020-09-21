<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 
class MstroDneCrgosGrpo extends Model
{
	protected $table = 'mstro_dne_crgos_grpos';
	protected $primaryKey = 'id_cls_dne_crgo';
	public $timestamps = false;

	protected $casts = [
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nom_cls_dne_crgo',
		'inactivo'
	];
}
