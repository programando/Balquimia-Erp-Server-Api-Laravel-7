<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasAllowanceCharge
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property bool $charge_indicator
 * @property int $discount_id
 * @property string $allowance_charge_reason
 * @property float $amount
 * @property float $base_amount
 * 
 * @property FctrasElctrnca $fctras_elctrnca
 *
 * @package App\Models
 */
class FctrasElctrncasAllowanceCharge extends Model
{
	protected $table = 'fctras_elctrncas_allowance_charges';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'charge_indicator' => 'bool',
		'discount_id' => 'int',
		'amount' => 'float',
		'base_amount' => 'float'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'charge_indicator',
		'discount_id',
		'allowance_charge_reason',
		'amount',
		'base_amount'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}

	public function getAllowanceChargeReasonAttribute ( $value ) {
			return trim ( $value );
		}
}
