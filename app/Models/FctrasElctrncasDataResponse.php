<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FctrasElctrncasDataResponse extends Model
{
	protected $table = 'fctras_elctrncas_data_response';
	protected $primaryKey = 'id_fact_elctrnca';
	public $incrementing = false;
	public $timestamps = false;

 
	protected $fillable = [
		'qr_data',
		'application_response_base64_bytes',
		'attached_document_base64_bytes',
		'pdf_base64_bytes',
		'zip_base64_bytes'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}
}
