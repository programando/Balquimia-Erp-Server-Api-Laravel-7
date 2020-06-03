<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasLegalMonetaryTotal
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property float $line_extension_amount
 * @property float $tax_exclusive_amount
 * @property float $tax_inclusive_amount
 * @property float $allowance_total_amount
 * @property float $charge_total_amount
 * @property float $payable_amount
 * 
 * @property FctrasElctrncasHeader $fctras_elctrncas_header
 *
 * @package App\Models
 */
class FctrasElctrncasLegalMonetaryTotal extends Model
{
	protected $table = 'fctras_elctrncas_legal_monetary_totals';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'line_extension_amount' => 'float',
		'tax_exclusive_amount' => 'float',
		'tax_inclusive_amount' => 'float',
		'allowance_total_amount' => 'float',
		'charge_total_amount' => 'float',
		'payable_amount' => 'float'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'line_extension_amount',
		'tax_exclusive_amount',
		'tax_inclusive_amount',
		'allowance_total_amount',
		'charge_total_amount',
		'payable_amount'
	];

	public function fctras_elctrncas_header()
	{
		return $this->belongsTo(FctrasElctrncasHeader::class, 'id_fact_elctrnca');
	}
}
