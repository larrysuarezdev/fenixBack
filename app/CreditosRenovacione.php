<?php

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

class CreditosRenovacione extends Eloquent
{
	protected $casts = [
		'credito_id' => 'int',
		'estado' => 'bool'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'credito_id',
		'observaciones',
		'estado',
		'fecha'
	];

	public function credito()
	{
		return $this->belongsTo(\App\Credito::class);
	}
}
