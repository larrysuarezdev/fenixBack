<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class addCreditoRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cliente_id' => 'required|numeric',
            'ruta_id' => 'required|numeric',
            'inicio_credito' => 'required',
            'valor_prestamo' => 'required',
            'mod_cuota' => 'required',
            'mod_dias' => 'required',
            'obs_dia' => '',
        ];
    }
}
