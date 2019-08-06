<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FlujoCajaRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descripcion' => 'required',
            'tipo' => 'required',
            'valor' => 'required',
            'fecha' => 'required'
        ];
    }
}
