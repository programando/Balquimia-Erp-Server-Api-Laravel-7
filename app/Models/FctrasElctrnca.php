<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
//use App\Events\NewInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
 
class FctrasElctrnca extends Model
{
	protected $primaryKey   = 'id_fact_elctrnca';
	protected $table        = 'fctras_elctrncas';
	public    $allowedSorts = ['fcha_dcmnto'];
	public    $timestamps   = false;
	public    $type         = 'facturas-electronicas';

	protected $casts = [
		'number'            => 'int',
		'sync'              => 'bool',
		'send'              => 'bool',
		'type_operation_id' => 'int',
		'type_document_id'  => 'int',
		'resolution_id'     => 'int',
		'type_currency_id'  => 'int',
		'rspnse_dian'       => 'bool',
		'rspnse_is_valid'   => 'bool'
	];

	protected $dates = [
		'due_date',
		'rspnse_issue_date',
		'fcha_dcmnto'
	];

	protected $fillable = [
		'number',
		'sync',
		'send',
		'notes',
		'type_operation_id',
		'type_document_id',
		'resolution_id',
		'fcha_dcmnto',
		'due_date',
		'type_currency_id',
		'order_reference',
		'receipt_document_reference',
		'rspnse_dian',
		'is_valid',
		'document_number',
		'uuid',
		'issue_date',
		'zip_key',
		'status_code',
		'status_description',
		'status_message',
		'xml_file_name',
		'zip_name',
		'cstmer_rspnse',
		'cstmer_rspnse_date'
	];

		public function fields(){
			return [
					'id'					 => $this->id_fact_elctrnca,
					'prefijo'			 => $this->prfjo_dcmnto,
					'number'        => $this->number,
					'fcha_dcmnto'   => $this->fcha_dcmnto,
					'diffForHumans' => $this->fcha_dcmnto->diffForHumans(),
					'fecha-factura'        => $this->fcha_dcmnto->format('d-M-Y'),
					'rspnse_dian'   => $this->is_valid,
			];
		}

		public function customer() {
			return $this->hasOne(FctrasElctrncasCustomer::class, 'id_fact_elctrnca');
			
		}

		public function total() {
			return $this->hasOne(FctrasElctrncasLegalMonetaryTotal::class, 'id_fact_elctrnca');
		}
		public function products() {
			return $this->hasMany(FctrasElctrncasInvoiceLine::class, 'id_fact_elctrnca');
		}
		public function emails() {
			return $this->hasMany(FctrasElctrncasEmailSend::class, 'id_fact_elctrnca');
		}
		public function noteBillingReference() {
			return $this->hasOne(FctrasElctrncasNotesBillingReference::class, 'id_fact_elctrnca');
		}
		public function noteDiscrepancy() {
			return $this->hasOne(FctrasElctrncasNotesDiscrepancyResponse::class, 'id_fact_elctrnca');
		}
		public function additionals() {
			return $this->hasOne(FctrasElctrncasAdditional::class, 'id_fact_elctrnca');
		}
		public function serviceResponse() {
			return $this->hasOne(FctrasElctrncasDataResponse::class, 'id_fact_elctrnca');
		}
	
/* 			public function charges() {
			return $this->hasOne(FctrasElctrncasAllowanceCharges::class, 'id_fact_elctrnca');
		} */


 


		// SCOPES
		//=========
			public function scopeInvoicesToSend ( $query ){
				return $query->Where('rspnse_dian','0')->where('type_document_id', '1'); // Facturas
			}
			public function scopeCreditNotesToSend ( $query ){
				return $query->Where('rspnse_dian','0')->whereIn('type_document_id', array('5','6'));	// Notas Crédito/Débito
			}
			
		// ACCESORS
		//=========
			public function getDocumentNumberAttribute( $value ){
				return trim($value);
			}
			

			public function getPrfjoDcmntoAttribute( $value ){
				return trim($value);
			}
			public function getUuidAttribute( $value ){
				return trim($value);
			}



	}
