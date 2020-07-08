<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Frase extends Model
{
	protected $table = 'frases';
	protected $primaryKey = 'id_frase';
	public $timestamps = false;

	protected $casts = [
		'id_terc' => 'int'
	];

	protected $fillable = [
		'id_terc',
		'nom_frase',
		'autor'
	];

	public function scopefraseDelDia ( $query ) {
			return $this->orderByRaw('rand()')->take(1)->get();
	}

	public function getNomFraseAttribute ( $value ){
		return trim( $value );
	}

}
