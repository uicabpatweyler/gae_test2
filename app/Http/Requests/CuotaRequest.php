<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CuotaRequest extends FormRequest
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

    public function storeRules(){
        return [
            'escuela_id' => 'required',
            'ciclo_id'   => 'required',
            'nombre'     => 'required',
            'tipo'       => 'required',
            'cuota'      => [
                'required|gt:0',
                Rule::unique('cuotas')->where( function($query) {
                    return $query->where('escuela_id', $this->escuela_id)
                        ->where('ciclo_id', $this->ciclo_id)
                        ->where('tipo', $this->tipo)
                        ->where('cuota', $this->cuota);
                })
            ]
        ];
    }

    public function updateRules(){
        return [
            'escuela_id' => 'required',
            'ciclo_id'   => 'required',
            'nombre'     => 'required',
            'tipo'       => 'required',
            'cuota'      => [
                'required|gt:0',
                Rule::unique('cuotas')->where( function($query) {
                    return $query->where('escuela_id', $this->escuela_id)
                        ->where('ciclo_id', $this->ciclo_id)
                        ->where('tipo', $this->tipo)
                        ->where('cuota', $this->cuota);
                })->ignore($this->cuota->id)
            ]
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->isMethod('post')) {
            return $this->storeRules();
        }
        else if($this->isMethod('put') || $this->isMethod('patch')){
            return $this->updateRules();
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'escuela_id.required' => 'Elija una escuela',
            'ciclo_id.required'   => 'Elija el ciclo',
            'nombre.required'     => 'Nombre o breve descripción',
            'tipo.required'       => 'Elija el tipo de cuota',
            'cuota.required'      => 'Falta la cuota',
            'cuota.gt'            => 'Cuota incorrecta'

        ];
    }
}
