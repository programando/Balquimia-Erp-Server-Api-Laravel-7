<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasEmailSend
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property string $email
 * 
 * @property FctrasElctrncasHeader $fctras_elctrncas_header
 *
 * @package App\Models
 */
class FctrasElctrncasEmailSend extends Model
{
	protected $table = 'fctras_elctrncas_email_sends';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'email'
	];

	public function fctras_elctrncas_header()
	{
		return $this->belongsTo(FctrasElctrncasHeader::class, 'id_fact_elctrnca');
	}

	public function getEmailAttribute ( $value ){
		return trim ( $value );
	}
}
