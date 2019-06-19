<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumnoRequest extends FormRequest
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
        'curp'            => 'required|unique:alumnos|min:23|max:23',
        'nombre1'         => 'required|min:2|max:60',
        'apellido1'       => 'required|min:2|max:60',
        'fechanacimiento' => 'required',
        'genero'          => 'required|min:1|max:1'
      ];
    }

    public function updateRules(){}

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
      'curp.required'    => 'Falta la C.U.R.P.',
      'curp.unique'      => 'Esta C.U.R.P. ya existe',
      'curp.min'         => 'C.U.R.P. incorrecta',
      'curp.max'         => 'C.U.R.P. incorrecta',
      'nombre1.required' => 'Falta el nombre',
      'nombre1.min'      => 'Nombre incorrecto',
      'nombre1.max'      => 'Nombre incorrecto',
      'apellido1.required'  => 'Falta el apellido',
      'apellido1.min'       => 'Apellido incorrecto',
      'apellido1.max'       => 'Apellido incorrecto',
      'fechanacimiento.required'    => 'Falta la fecha de nac.',
      'genero.required'             => 'Obligatorio'
    ];
  }
}
