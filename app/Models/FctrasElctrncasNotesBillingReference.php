<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasNotesBillingReference
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property int $number
 * @property string $uuid
 * @property Carbon $issue_date
 * 
 * @property FctrasElctrnca $fctras_elctrnca
 *
 * @package App\Models
 */
class FctrasElctrncasNotesBillingReference extends Model
{
	protected $table = 'fctras_elctrncas_notes_billing_reference';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'number' => 'int'
	];
 
	protected $dates = [
		'issue_date'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'number',
		'uuid',
		'issue_date'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}
}
