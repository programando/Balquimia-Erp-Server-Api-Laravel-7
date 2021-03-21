<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Helpers\StringHelper as Strings;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TercerosUser extends Authenticatable
{
	use Notifiable;

	protected $primaryKey   = 'id_terc';
	protected $table        = 'terceros_users';
	public    $incrementing = false;

	protected $casts    = [	'id_terc' => 'int',		'inactivo' => 'bool',		'autorizado' => 'bool'	];
	protected $dates    = [ 'tmp_token_expira'	];
	protected $fillable = [ 'email',		'password',			'inactivo',			'autorizado',		'avatar',		'remember_token',		'tmp_token',		'tmp_token_expira'	];
	protected $hidden   = [	'password',	'remember_token',		'tmp_token'	];


     //  MUTATORS:
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
