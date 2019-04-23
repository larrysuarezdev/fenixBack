<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
	protected $table = 'personas';
	protected $fillable = [
		'old_id',
		'dui',
		'nombre',
		'apellidos',
		'direccion',
		'ciudad',
		'telefono',
		'email',
		'user_id',
		'is_active',
		'archivo_id',
		'thru_file',
		'sexo',
		'facultad',
		'contacto',
		'Lic_Desde',
		'Lic_Hasta'
	];
}
