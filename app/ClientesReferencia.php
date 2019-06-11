<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 15 May 2019 15:14:33 -0500.
 */

namespace App;

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
		return $this->belongsTo(\App\Cliente::class);
	}
}
