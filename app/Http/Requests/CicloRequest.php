<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CicloRequest extends FormRequest
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
        switch ($this->method()){
            case 'GET':
            case 'DELETE':
            case 'POST':{
                return [
                    'periodo' => 'required|unique:ciclos'
                ];
            }
            case 'PATCH': {
                return [
                    'periodo' => [
                        'required',
                        Rule::unique('ciclos')->ignore($this->ciclo->id)
                    ]
                ];
            }
            case 'PUT':
            default: break;
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
            'periodo.required' => 'Obligatorio',
            'periodo.unique'   => 'El periodo ya existe'
        ];
    }
}
