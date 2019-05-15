<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 04 May 2019 15:59:40 -0500.
 */

namespace App;

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
 * @property bool $activo
 * @property \Carbon\Carbon $inicio_credito
 * 
 * @property \App\Cliente $cliente
 * @property \Illuminate\Database\Eloquent\Collection $creditos_detalles
 *
 * @package App
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
		'activo',
		'inicio_credito'
	];

	public function cliente()
	{
		return $this->belongsTo(\App\Cliente::class);
	}

	public function creditos_detalles()
	{
		return $this->hasMany(\App\CreditosDetalle::class);
	}

	public static function getCreditos($id)
	{
		$creditos = Credito::with('cliente')->with('creditos_detalles')
					->where([['ruta_id', $id], ['activo', true]])->orderBy('orden', 'ASC')
					->get();
					
		return $creditos;
	}
}
