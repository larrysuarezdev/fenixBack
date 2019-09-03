<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Credito
 * 
 * @property int $id
 * @property int $orden
 * @property int $cliente_id
 * @property int $ruta_id
 * @property int $mora
 * @property float $cuotas_pagas
 * @property float $valor_prestamo
 * @property float $mod_cuota
 * @property string $mod_dias
 * @property string $observaciones
 * @property int $modalidad
 * @property bool $activo
 * @property \Carbon\Carbon $inicio_credito
 * 
 * @property \App\Models\Cliente $cliente
 * @property \Illuminate\Database\Eloquent\Collection $creditos_detalles
 * @property \Illuminate\Database\Eloquent\Collection $creditos_renovaciones
 *
 * @package App\Models
 */
class Credito extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'orden' => 'int',
		'cliente_id' => 'int',
		'ruta_id' => 'int',
		'mora' => 'int',
		'cuotas_pagas' => 'float',
		'valor_prestamo' => 'float',
		'mod_cuota' => 'float',
		'modalidad' => 'int',
		'activo' => 'bool'
	];

	protected $dates = [
		'inicio_credito'
	];

	protected $fillable = [
		'orden',
		'cliente_id',
		'ruta_id',
		'mora',
		'cuotas_pagas',
		'valor_prestamo',
		'mod_cuota',
		'mod_dias',
		'observaciones',
		'modalidad',
		'activo',
		'inicio_credito'
	];

	public function cliente()
	{
		return $this->belongsTo(\App\Models\Cliente::class);
	}

	public function creditos_detalles()
	{
		return $this->hasMany(\App\Models\CreditosDetalle::class);
	}

	public function creditos_renovaciones()
	{
		return $this->hasMany(\App\Models\CreditosRenovacione::class);
	}
}
