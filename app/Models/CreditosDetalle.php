<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CreditosDetalle
 * 
 * @property int $id
 * @property int $credito_id
 * @property int $usuario_id
 * @property float $abono
 * @property \Carbon\Carbon $fecha_abono
 * @property bool $estado
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Credito $credito
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class CreditosDetalle extends Eloquent
{
	protected $casts = [
		'credito_id' => 'int',
		'usuario_id' => 'int',
		'abono' => 'float',
		'estado' => 'bool'
	];

	protected $dates = [
		'fecha_abono'
	];

	protected $fillable = [
		'credito_id',
		'usuario_id',
		'abono',
		'fecha_abono',
		'estado'
	];

	public function credito()
	{
		return $this->belongsTo(\App\Models\Credito::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'usuario_id');
	}
}
