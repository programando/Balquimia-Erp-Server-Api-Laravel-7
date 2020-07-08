<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasCustomer
 * 
 * @property int $id
 * @property int $id_fact_elctrnca
 * @property int $identification_number
 * @property int $type_document_identification_id
 * @property int $type_organization_id
 * @property int $language_id
 * @property int $country_id
 * @property int $municipality_id
 * @property int $type_regime_id
 * @property int $type_liability_id
 * @property int $tax_detail_id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $merchant_registration
 * 
 * @property FctrasElctrnca $fctras_elctrnca
 *
 * @package App\Models
 */
class FctrasElctrncasCustomer extends Model
{
	protected $table = 'fctras_elctrncas_customers';
	public $timestamps = false;

	protected $casts = [
		'id_fact_elctrnca'                => 'int',
		'identification_number'           => 'int',
		'type_document_identification_id' => 'int',
		'type_organization_id'            => 'int',
		'language_id'                     => 'int',
		'country_id'                      => 'int',
		'municipality_id'                 => 'int',
		'type_regime_id'                  => 'int',
		'type_liability_id'               => 'int',
		'tax_detail_id'                   => 'int'
	];

	protected $fillable = [
		'id_fact_elctrnca',
		'identification_number',
		'type_document_identification_id',
		'type_organization_id',
		'language_id',
		'country_id',
		'municipality_id',
		'type_regime_id',
		'type_liability_id',
		'tax_detail_id',
		'name',
		'phone',
		'address',
		'email',
		'merchant_registration'
	];
	
/// RELATIONS
		public function fctras_elctrnca()
		{
			return $this->belongsTo(FctrasElctrnca::class, 'id_fact_elctrnca');
		}
// GETTERS
		public function getNameAttribute ( $value ) {
			return trim ( $value );
		}
		public function getPhoneAttribute ( $value ) {
			return trim ( $value );
		}

		public function getAddressAttribute ( $value ) {
			return trim ( $value );
		}
		public function getEmailAttribute ( $value ) {
			return trim ( $value );
		}

}
