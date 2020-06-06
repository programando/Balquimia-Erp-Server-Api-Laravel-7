<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrnca
 * 
 * @property int $id_fact_elctrnca
 * @property int $number
 * @property bool $sync
 * @property bool $send
 * @property string $notes
 * @property int $type_operation_id
 * @property int $type_document_id
 * @property int $resolution_id
 * @property Carbon $due_date
 * @property int $type_currency_id
 * @property string $order_reference
 * @property string $receipt_document_reference
 * @property Carbon $created_at
 * @property bool $rspnse_dian
 * @property bool $rspnse_is_valid
 * @property string $rspnse_number
 * @property string $rspnse_uuid
 * @property Carbon $rspnse_issue_date
 * @property string $rspnse_zip_key
 * @property string $rspnse_status_code
 * @property string $rspnse_status_description
 * @property string $rspnse_status_message
 * @property string $rspnse_xml_file_name
 * @property string $rpnse_zip_name
 * @property string $rpnse_qr_data
 * @property string $rpnse_application_response_base64_bytes
 * @property string $rpnse_attached_document_base64_bytes
 * @property string $rpnse_pdf_base64_bytes
 * @property string $rspnse_zip_base64_bytes
 * @property string $rspnse_dian_response_base64_bytes
 * 
 * @property Collection|FctrasElctrncasCustomer[] $fctras_elctrncas_customers
 * @property Collection|FctrasElctrncasEmailSend[] $fctras_elctrncas_email_sends
 * @property Collection|FctrasElctrncasInvoiceLine[] $fctras_elctrncas_invoice_lines
 * @property Collection|FctrasElctrncasLegalMonetaryTotal[] $fctras_elctrncas_legal_monetary_totals
 *
 * @package App\Models
 */
class FctrasElctrnca extends Model
{
	protected $table      = 'fctras_elctrncas';
	protected $primaryKey = 'id_fact_elctrnca';
	public    $timestamps = false;

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
		'qr_data',
		'application_response_base64_bytes',
		'attached_document_base64_bytes',
		'pdf_base64_bytes',
		'zip_base64_bytes',
		'dian_response_base64_bytes'
	];


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
			return $this->hasMany(FctrasElctrncasNotesBillingReference::class, 'id_fact_elctrnca');
		}
		public function noteDiscrepancy() {
			return $this->hasMany(FctrasElctrncasNotesDiscrepancyResponse::class, 'id_fact_elctrnca');
		}
		

		// SCOPES
		//=========
			public function scopeInvoicesToSend ( $query ){
				return $query->Where('rspnse_dian','0')->where('type_document_id', '1'); // Facturas
			}
			public function scopeCreditNotesToSend ( $query ){
				return $query->Where('rspnse_dian','0')->where('type_document_id', '5');	// Notas Crédito
			}

}
