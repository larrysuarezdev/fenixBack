<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 04 May 2019 15:59:40 -0500.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CreditosDetalle
 * 
 * @property int $id
 * @property int $cliente_id
 * @property float $abono
 * @property \Carbon\Carbon $fecha_abono
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Credito $credito
 *
 * @package App
 */
class CreditosDetalle extends Eloquent
{
	protected $casts = [
		'credito_id' => 'int',
		'cliente_id' => 'int',
		'abono' => 'float'
	];

	protected $dates = [
		'fecha_abono'
	];

	protected $fillable = [
		'credito_id',
		'cliente_id',
		'abono',
		'fecha_abono'
	];

	public function cliente()
	{
		return $this->belongsTo(\App\Cliente::class);
	}

	public function credito()
	{
		return $this->belongsTo(\App\Credito::class);
	}
}
