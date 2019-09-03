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

	public static function ChangeStateRenovacion($id)
	{		
		$renovaciones = CreditosRenovacione::where([['credito_id', $id], ['estado', true]])->get();
		foreach ($renovaciones as $key => $value) {
			$value->estado = false;
			$value->save();
		}
	}
}
