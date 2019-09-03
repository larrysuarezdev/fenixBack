<?php

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

class FlujoUtilidade extends Eloquent
{
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
