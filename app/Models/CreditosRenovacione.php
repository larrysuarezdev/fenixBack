<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CreditosRenovacione
 * 
 * @property int $id
 * @property int $credito_id
 * @property string $observaciones
 * @property float $excedente
 * @property bool $estado
 * @property \Carbon\Carbon $fecha
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Credito $credito
 *
 * @package App\Models
 */
class CreditosRenovacione extends Eloquent
{
	protected $casts = [
		'credito_id' => 'int',
		'excedente' => 'float',
		'estado' => 'bool'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'credito_id',
		'observaciones',
		'excedente',
		'estado',
		'fecha'
	];

	public function credito()
	{
		return $this->belongsTo(\App\Models\Credito::class);
	}
}
