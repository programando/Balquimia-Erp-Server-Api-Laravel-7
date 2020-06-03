<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasNotesDiscrepancyResponse
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property string $reference
 * @property int $correction_concept_id
 * @property string $description
 * 
 * @property FctrasElctrnca $fctras_elctrnca
 *
 * @package App\Models
 */
class FctrasElctrncasNotesDiscrepancyResponse extends Model
{
	protected $table = 'fctras_elctrncas_notes_discrepancy_response';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'correction_concept_id' => 'int'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'reference',
		'correction_concept_id',
		'description'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}
}
