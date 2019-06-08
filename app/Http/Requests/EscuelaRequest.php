<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EscuelaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()){
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'cct'           => 'required|unique:escuelas|min:10|max:10',
                        'nombre'        => 'required|max:120',
                        'tipo_id'       => 'required',
                        'nivel_id'      => 'required',
                        'servicio_id'   => 'required',
                        'turno'         => 'required',
                        'sostenimiento' => 'required'
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'cct' => [
                            'required',
                            Rule::unique('escuelas')->ignore($this->escuela->id),
                            'min:10',
                            'max:10'
                        ],
                        'nombre'        => 'required|max:120',
                        'tipo_id'       => 'required',
                        'nivel_id'      => 'required',
                        'servicio_id'   => 'required',
                        'turno'         => 'required',
                        'sostenimiento' => 'required'
                    ];
                }
            default:break;
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'tipo_id'                => 'Elija el tipo',
            'nivel_id.required'      => 'Elija el nivel',
            'servicio_id.required'   => 'Elija el servicio',
            'cct.required'           => 'Falta la clave',
            'nombre.required'        => 'Falta el nombre',
            'turno.required'         => 'Elija el turno',
            'sostenimiento.required' => 'Elija público o privado',

            'cct.unique' => 'Esta clave ya existe',
            'cct.min'    => 'Min. 10 caracteres',
            'cct.max'    => 'Max. 10 caracteres',

            'nombre.max' => 'Max. 60 caracteres'
        ];
    }
}
