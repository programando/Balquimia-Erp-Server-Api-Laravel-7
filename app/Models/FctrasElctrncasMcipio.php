<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FctrasElctrncasMcipio
 * 
 * @property int $id
 * @property int $id_mcpio
 * @property string $cod_mcpio
 * @property string $name_mcpio
 *
 * @package App\Models
 */
class FctrasElctrncasMcipio extends Model
{
	protected $table = 'fctras_elctrncas_mcipios';
	public $timestamps = false;

	protected $casts = [
		'id_mcpio' => 'int'
	];

	protected $fillable = [
		'id_mcpio',
		'cod_mcpio',
		'name_mcpio'
	];

	//GETTTERS
		public function getNameMcpioAttribute ( $value ) {
			return trim ( $value );
		}

}
