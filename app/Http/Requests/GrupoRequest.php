<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GrupoRequest extends FormRequest
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
        'ciclo_id' => 'required',
        'grado_id' => 'required',
        'nombre' => [
          'required',
          Rule::unique('grupos')->where( function($query) {
            return $query->where('escuela_id', $this->escuela_id)
              ->where('ciclo_id', $this->ciclo_id)
              ->where('grado_id', $this->grado_id)
              ->where('nombre', mb_convert_case($this->nombre,MB_CASE_UPPER,'UTF-8'));
          })
        ],
        'cupoalumnos' => 'required'
      ];
    }

    public function updateRules(){
      return [
        'escuela_id' => 'required',
        'ciclo_id' => 'required',
        'grado_id' => 'required',
        'nombre' => [
          'required',
          Rule::unique('grupos')->where( function($query) {
            return $query->where('escuela_id', $this->escuela_id)
              ->where('ciclo_id', $this->ciclo_id)
              ->where('grado_id', $this->grado_id)
              ->where('nombre', mb_convert_case($this->nombre,MB_CASE_UPPER,'UTF-8'));
          })->ignore($this->grupo->id)
        ],
        'cupoalumnos' => 'required'
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
      'escuela_id.required' => 'Elija la escuela',
      'ciclo_id.required' => 'Elija el ciclo escolar',
      'grado_id.required' => 'Elija el grado',
      'nombre.required'     => 'Falta el nombre del grupo',
      'nombre.unique'       => 'Este grupo ya existe',
      'cupoalumnos.required' => 'Obligatorio'

    ];
  }
}
