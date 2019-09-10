<?php

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

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
		'activo' => 'bool',
		'eliminado' => 'bool'
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
		'eliminado',
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

	public function creditos_renovaciones()
	{
		return $this->hasMany(\App\CreditosRenovacione::class);
	}

	public static function getCreditos($id)
	{
		$creditos = Credito::with('cliente')
			->with('creditos_detalles.user')
			->with(['creditos_detalles' => function ($v) {
				$v->where('estado', true);
			}])
			->with(['creditos_renovaciones' => function ($c) {
				$c->where('estado', true);
			}])
			->where([['ruta_id', $id], ['activo', true]])->orderBy('orden', 'ASC')
			->get();

		return $creditos;
	}

	public static function CreditoUsuarioActivo($id)
	{
		$res = false;
		$creditos = Credito::where([['cliente_id', $id], ['activo', true]])->get();
		if (count($creditos) > 0)
			$res = true;

		return $res;
	}

	public static function ChangeStateCredito($id)
	{
		$res = true;
		$credito = Credito::with(['creditos_detalles' => function ($v) {
			$v->where('estado', true);
		}])
			->where([['id', $id], ['activo', true]])->orderBy('orden', 'ASC')
			->get();

		$valor_total = $credito[0]->mod_cuota * $credito[0]->mod_dias;
		$total_pago_fecha = $credito[0]->creditos_detalles->sum('abono');

		if ($valor_total == $total_pago_fecha) {
			$res = false;
		}		
		return $res;
	}
}
