<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ClientesReferencia
 * 
 * @property int $id
 * @property int $cliente_id
 * @property string $nombre
 * @property string $direccion
 * @property string $barrio
 * @property string $telefono
 * @property string $parentesco
 * @property string $tipo_referencia
 * 
 * @property \App\Models\Cliente $cliente
 *
 * @package App\Models
 */
class ClientesReferencia extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'cliente_id' => 'int'
	];

	protected $fillable = [
		'cliente_id',
		'nombre',
		'direccion',
		'barrio',
		'telefono',
		'parentesco',
		'tipo_referencia'
	];

	public function cliente()
	{
		return $this->belongsTo(\App\Models\Cliente::class);
	}
}
