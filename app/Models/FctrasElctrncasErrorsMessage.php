<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasErrorsMessage
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property string $error_message
 * 
 * @property FctrasElctrnca $fctras_elctrnca
 *
 * @package App\Models
 */
class FctrasElctrncasErrorsMessage extends Model
{
	protected $table = 'fctras_elctrncas_errors_messages';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'error_message'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}
}
