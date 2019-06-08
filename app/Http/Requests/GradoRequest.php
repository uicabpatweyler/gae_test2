<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
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

    public function storeRules(){
        return [
            'escuela_id' => 'required',
            'ciclo_id'   => 'required',
            'nombre'     => 'required'
        ];
    }

    public function updateRules(){
        return [
            'escuela_id' => 'required',
            'ciclo_id'   => 'required',
            'nombre'     => 'required'
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
            'ciclo_id.required'   => 'Elija un periodo',
            'nombre.required'     => 'Falta el nombre',
        ];
    }
}
