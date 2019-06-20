<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DireccionAlumnoRequest extends FormRequest
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

  public function storeRules()
  {
    return [
      'alumno_id'           => 'required',
      'nombre_vialidad'     => 'required',
      'exterior'            => 'required',
      'tipo_asentamiento'   => 'required',
      'nombre_asentamiento' => 'required',
      'codigo_postal'       => 'required',
      'localidad'           => 'required',
      '_delegacion'         => 'required',
      '_estado'             => 'required',
      'colonia'             => 'required',
    ];
  }

  public function updateRules()
  {
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'alumno_id.required'           => 'Obligatorio',
      'nombre_vialidad.required'     => 'Obligatorio',
      'exterior.required'            => 'Obligatorio',
      'tipo_asentamiento.required'   => 'Obligatorio',
      'nombre_asentamiento.required' => 'Obligatorio',
      'codigo_postal.required'       => 'Obligatorio',
      'localidad.required'           => 'Obligatorio',
      '_delegacion.required'         => 'Seleccione un valor',
      '_estado.required'             => 'Seleccione un valor',
      'colonia.required'             => 'Seleccione un valor'
    ];
  }
}
