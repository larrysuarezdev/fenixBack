<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:07 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Cliente
 * 
 * @property int $id
 * @property string $titular
 * @property string $cc_titular
 * @property string $fiador
 * @property string $cc_fiador
 * @property string $neg_titular
 * @property string $neg_fiador
 * @property string $dir_cobro
 * @property string $barrio_cobro
 * @property string $tel_cobro
 * @property string $dir_casa
 * @property string $barrio_casa
 * @property string $tel_casa
 * @property string $dir_fiador
 * @property string $barrio_fiador
 * @property string $tel_fiador
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $clientes_referencias
 * @property \Illuminate\Database\Eloquent\Collection $creditos
 *
 * @package App\Models
 */
class Cliente extends Eloquent
{
	protected $casts = [
		'estado' => 'bool'
	];

	protected $fillable = [
		'titular',
		'cc_titular',
		'fiador',
		'cc_fiador',
		'neg_titular',
		'neg_fiador',
		'dir_cobro',
		'barrio_cobro',
		'tel_cobro',
		'dir_casa',
		'barrio_casa',
		'tel_casa',
		'dir_fiador',
		'barrio_fiador',
		'tel_fiador',
		'estado'
	];

	public function clientes_referencias()
	{
		return $this->hasMany(\App\Models\ClientesReferencia::class);
	}

	public function creditos()
	{
		return $this->hasMany(\App\Models\Credito::class);
	}
}
