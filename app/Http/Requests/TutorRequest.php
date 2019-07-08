<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TutorRequest extends FormRequest
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
      if($this->isMethod('post')) {
        return $this->storeRules();
      }
      else if($this->isMethod('put') || $this->isMethod('patch')){
        return $this->updateRules();
      }
    }

  public function storeRules() {
      return [
        'nombre'    => [
          'required',
          'min:2',
          'max:60',
          Rule::unique('tutores')->where( function($query) {
            return $query->where('nombre', mb_convert_case($this->nombre,MB_CASE_TITLE,'UTF-8'))
              ->where('apellido1', mb_convert_case($this->apellido1,MB_CASE_TITLE,'UTF-8'))
              ->where('apellido2', mb_convert_case($this->apellido2,MB_CASE_TITLE,'UTF-8'));
          })
        ],
        'apellido1' => 'required|min:2|max:60',
        'genero'    => 'required'
      ];
  }

  public function updateRules() {
    return [
      'nombre'    => [
        'required',
        'min:2',
        'max:60',
        Rule::unique('tutores')->where( function($query) {
          return $query->where('nombre', mb_convert_case($this->nombre,MB_CASE_TITLE,'UTF-8'))
            ->where('apellido1', mb_convert_case($this->apellido1,MB_CASE_TITLE,'UTF-8'))
            ->where('apellido2', mb_convert_case($this->apellido2,MB_CASE_TITLE,'UTF-8'));
        })->ignore($this->tutor->id)
      ],
      'apellido1' => 'required|min:2|max:60',
      'genero'    => 'required'
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
      'nombre.required' => 'Falta el nombre',
      'nombre.min' => 'Min. 2 caracteres',
      'nombre.max' => 'Máx. 60 caracteres',
      'nombre.unique' => 'Este tutor ya existe',
      'apellido1.required' => 'Falta el apellido',
      'apellido1.min' => 'Min. 2 caracteres',
      'apellido1.max' => 'Máx. 60 caracteres',
      'genero.required' => 'Elija el genero del tutor'
    ];
  }
}
