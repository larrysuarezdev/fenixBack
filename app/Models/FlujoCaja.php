<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FlujoCaja
 * 
 * @property int $id
 * @property string $descripcion
 * @property int $tipo
 * @property float $valor
 * @property \Carbon\Carbon $fecha
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class FlujoCaja extends Eloquent
{
	protected $table = 'flujo_caja';

	protected $casts = [
		'tipo' => 'int',
		'valor' => 'float'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'descripcion',
		'tipo',
		'valor',
		'fecha'
	];
}
