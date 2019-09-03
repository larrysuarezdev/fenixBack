<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FlujoUtilidadesRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descripcion' => 'required',
            'valor' => 'required',
            'tipo' => 'required',
            'fecha' => 'required'
        ];
    }
}
