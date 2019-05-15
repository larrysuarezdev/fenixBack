<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 04 May 2019 15:59:40 -0500.
 */

namespace App;

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
 * 
 * @property \Illuminate\Database\Eloquent\Collection $creditos
 *
 * @package App
 */
class Cliente extends Eloquent
{
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
		'tel_fiador'
	];

	public function creditos()
	{
		return $this->hasMany(\App\Credito::class);
	}

	public function creditos_detalles()
	{
		return $this->hasMany(\App\CreditosDetalle::class);
	}
}
