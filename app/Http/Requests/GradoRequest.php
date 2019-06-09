<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradoRequest extends FormRequest
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

    //https://stackoverflow.com/questions/50349775/laravel-unique-validation-on-multiple-columns
    public function storeRules(){
        return [
            'escuela_id' => 'required',
            'nombre'     => [
                'required',
                Rule::unique('grados')->where(function ($query)  {
                    return $query->where('escuela_id', $this->escuela_id)
                        ->where('nombre', $this->nombre);
                })
            ]
        ];
    }

    public function updateRules(){
        return [
            'escuela_id' => 'required',
            'nombre'     => [
                'required',
                Rule::unique('grados')->where(function ($query)  {
                    return $query->where('escuela_id', $this->escuela_id)
                        ->where('nombre', $this->nombre);
                })->ignore($this->grado->id),
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
            'nombre.unique'       => 'Este grado ya existe',
            'nombre.required'     => 'Falta el nombre',
        ];
    }
}
