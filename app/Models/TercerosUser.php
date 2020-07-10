<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\StringHelper as Strings;

class TercerosUser extends Model
{
	protected $table = 'terceros_users';
	protected $primaryKey = 'id_terc';
	public $incrementing = false;

	protected $casts = [
		'id_terc' => 'int',
		'inactivo' => 'bool',
		'autorizado' => 'bool'
	];

	protected $dates = [
		'tmp_token_expira'
	];

	protected $hidden = [
		'password',
		'remember_token',
		'tmp_token'
	];

	protected $fillable = [
		'email',
		'password',
		'inactivo',
		'autorizado',
		'avatar',
		'remember_token',
		'tmp_token',
		'tmp_token_expira'
	];


	     
     //  MUTATORS:  Modifican datos antes de que lleguen a la base de datos
   		public function setPasswordAttribute ( $value ){
					$this->attributes['password'] = Hash::make( $value );
			}

			public function setEmailAttribute ( $value ){
					$this->attributes['email']          = Strings::LowerTrim( $value );
			}

			public function getEmailAttribute ( $value ){
				return trim ( $value );
			}

}
