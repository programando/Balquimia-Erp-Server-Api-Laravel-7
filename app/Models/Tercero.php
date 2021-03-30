<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class Tercero extends Model
{
	protected $table = 'terceros';
	protected $primaryKey = 'id_terc';
	public $timestamps = false;

	protected $casts = [
		'id_idntfcion' => 'int',
		'id_mcipio' => 'int',
		'id_linea_cli' => 'int',
		'id_terc_vend_ppal' => 'int',
		'id_terc_vend_secd' => 'int',
		'es_cliente' => 'bool',
		'es_proveedor' => 'bool',
		'es_empleado' => 'bool',
		'es_vendedor' => 'bool',
		'vend_free' => 'bool',
		'vend_listados' => 'bool',
		'usuario' => 'bool',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nro_identif',
		'dv',
		'id_idntfcion',
		'id_mcipio',
		'id_linea_cli',
		'id_terc_vend_ppal',
		'id_terc_vend_secd',
		'nom_full',
		'nom_ccial',
		'nom_suc',
		'nom_fact',
		'email',
		'direcc',
		'nro_tel',
		'nro_cel',
		'es_cliente',
		'es_proveedor',
		'es_empleado',
		'es_vendedor',
		'vend_free',
		'vend_cod',
		'vend_listados',
		'vend_nom_fact',
		'usuario',
		'inactivo'
	];

	public function terceros_notas()
	{
		return $this->hasMany(TercerosNota::class, 'id_terc_usua');
	}
   /*---------------------------------------------------
        SCOPES
   ---------------------------------------------------*/
	        public function scopeclientesActivosPorVendedor($query, $idTercVendedor){
            return $query->Where('es_cliente','1')
                  ->Where('inactivo','0')
									->Where('id_terc_vend_ppal',$idTercVendedor);
        }

        public function scopeclientesBuscarNomSucNitNomCcial ( $query, $Filtro){
           return $query
                    ->Where('nom_full'         ,'LIKE'   , "%$Filtro%")
                    ->orWhere('nom_suc'       ,'LIKE'   , "%$Filtro%")
                    ->orWhere('nro_identif'   ,'LIKE'   , "%$Filtro%")
                    ->orWhere('nom_ccial'     ,'LIKE'   , "%$Filtro%");

        }

				public function getNomFullAttribute( $value){
					 return  trim( $value );
				}
			  public function getNomSucAttribute( $value){
					 return  trim( $value );
				}
			  public function getNomCcialAttribute( $value){
					 return  trim( $value );
				}	
			  public function getNroIdentifAttribute( $value){
					 return  trim( $value );
				}								
}
