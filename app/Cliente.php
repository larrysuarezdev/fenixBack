<?php

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

class Cliente extends Eloquent
{
	protected $table = 'clientes';
	protected $primaryKey = 'id';

	public $timestamps = false;

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
}
