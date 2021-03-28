<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class BtcraVta extends Model
{
	protected $table = 'btcra_vtas';
	protected $primaryKey = 'id_btcra';
	public $timestamps = false;

	protected $casts = [
		'id_terc'            => 'int',
		'id_terc_trnspdor'   => 'int',
		'id_terc_usrio'      => 'int',
		'id_terc_mnv'        => 'int',
		'id_dpto'            => 'int',
		'id_mcipio'          => 'int',
		'id_linea_cli'       => 'int',
		'id_linea_vend_fact' => 'int',
		'id_zna_vta'         => 'int',
		'id_terc_vend_ppal'  => 'int',
		'id_terc_vend_secd'  => 'int',
		'id_terc_vend_fact'  => 'int',
		'id_ped'             => 'int',
		'num_ped'            => 'int',
		'id_fact'            => 'int',
		'num_fact'           => 'int',
		'plazo_fact'         => 'int',
		'anio_fact'          => 'int',
		'mes_fact'           => 'int',
		'fact_nula'          => 'int',
		'fact_nula_id_terc'  => 'int',
		'fact_kardex'        => 'int',
		'pctje_dscto_fact'   => 'float',
		'vr_dscto_fact'      => 'float',
		'vr_flete_fact'      => 'float',
		'vr_subtot_fact'     => 'float',
		'vr_iva_fact'        => 'float',
		'vr_total_fact'      => 'float',
		'id_prd_ppal'        => 'int',
		'id_prd'             => 'int',
		'id_prsntcion'       => 'int',
		'idlinea_prd'        => 'int',
		'und_empque'         => 'float',
		'peso_kg'            => 'float',
		'peso_grm'           => 'float',
		'cant'               => 'float',
		'vr_precio_lista'    => 'float',
		'vr_flete'           => 'float',
		'vr_precio_adic'     => 'float',
		'PctjeDscto'         => 'float',
		'vr_dscto'           => 'float',
		'pcje_iva'           => 'float',
		'vr_iva'             => 'float',
		'vr_unit_real'       => 'float',
		'vr_tot_item'        => 'float',
		'intg_ok'            => 'int'
	];

	protected $dates = [
		'fcha_rgstro',
		'fcha_ped',
		'fcha_fact',
		'fcha_vnce',
		'fact_nula_fcha'
	];

	protected $fillable = [
		'fcha_rgstro',
		'id_terc',
		'id_terc_trnspdor',
		'id_terc_usrio',
		'id_terc_mnv',
		'nro_identif',
		'nom_full',
		'id_dpto',
		'nom_dpto',
		'id_mcipio',
		'nom_mcpio',
		'id_linea_cli',
		'cod_linea_cli',
		'nom_linea_cli',
		'id_linea_vend_fact',
		'cod_linea_vend_fact',
		'nom_linea_vend_fact',
		'id_zna_vta',
		'nom_zna_vta',
		'id_terc_vend_ppal',
		'id_terc_vend_secd',
		'id_terc_vend_fact',
		'vend_cod_ppal',
		'vend_cod_secd',
		'vend_cod_fact',
		'nom_vend_ppal',
		'nom_vend_secd',
		'nom_vend_fact',
		'id_ped',
		'num_ped',
		'fcha_ped',
		'num_ord_cpra',
		'id_fact',
		'prfjo_rslcion',
		'num_fact',
		'fcha_fact',
		'plazo_fact',
		'fcha_vnce',
		'anio_fact',
		'mes_fact',
		'fact_nula',
		'fact_nula_mtvo',
		'fact_nula_fcha',
		'fact_nula_id_terc',
		'fact_observ',
		'fact_kardex',
		'pctje_dscto_fact',
		'vr_dscto_fact',
		'vr_flete_fact',
		'vr_subtot_fact',
		'vr_iva_fact',
		'vr_total_fact',
		'tp_prd',
		'id_prd_ppal',
		'id_prd',
		'id_prsntcion',
		'idlinea_prd',
		'nom_linea_prd',
		'clave',
		'nom_prd',
		'nom_present',
		'descrip',
		'und_empque',
		'peso_kg',
		'peso_grm',
		'cant',
		'vr_precio_lista',
		'vr_flete',
		'vr_precio_adic',
		'PctjeDscto',
		'vr_dscto',
		'pcje_iva',
		'vr_iva',
		'vr_unit_real',
		'vr_tot_item',
		'nro_hpn_fact',
		'intg_ok'
	];

	public function scopevendedorUltimosDosAnios( $query, $idTercVendedor) {
		   $nomCahe = 'VtasVendedorUltimosDosAnios'.$idTercVendedor;
			 $VtasUltimosDosAnios  = Cache::tags( $nomCahe )->remember( $nomCahe ,60,   function(  )  use ($idTercVendedor)  {   
              return     DB::select(' call comercial_rptes_vta_vendedor_ultimos_2_anios ( ?)', array($idTercVendedor));
        });
        return $VtasUltimosDosAnios ;
			}
	}
