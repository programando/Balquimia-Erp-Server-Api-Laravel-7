<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasInvoiceLine
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property int $unit_measure_id
 * @property float $invoiced_quantity
 * @property float $line_extension_amount
 * @property bool $free_of_charge_indicator
 * @property string $description
 * @property string $brand_name
 * @property string $model_name
 * @property string $code
 * @property int $type_item_identification_id
 * @property float $price_amount
 * @property float $base_quantity
 * 
 * @property FctrasElctrnca $fctras_elctrnca
 *
 * @package App\Models
 */
class FctrasElctrncasInvoiceLine extends Model
{
	protected $table = 'fctras_elctrncas_invoice_lines';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca' => 'int',
		'unit_measure_id' => 'int',
		'invoiced_quantity' => 'float',
		'line_extension_amount' => 'float',
		'free_of_charge_indicator' => 'bool',
		'type_item_identification_id' => 'int',
		'price_amount' => 'float',
		'base_quantity' => 'float'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'unit_measure_id',
		'invoiced_quantity',
		'line_extension_amount',
		'free_of_charge_indicator',
		'description',
		'brand_name',
		'model_name',
		'code',
		'type_item_identification_id',
		'price_amount',
		'base_quantity',
		'tax_amount',
		'taxable_amount',
		'percent'
	];

	public function fctras_elctrnca()
	{
		return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
	}
	/// GETTERS
	public function getDescriptionAttribute ( $value ){
		return trim( $value );
	}
}
