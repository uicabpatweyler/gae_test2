<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InscripcionRequest extends FormRequest
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

    public function storeRules(){
      return [
        'grado_grupo' => 'required',
        'fecha'       => 'required|date_format:d-m-Y'
      ];
    }

    public function updateRules(){}

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'grado_grupo.required' => 'Falta el grupo',
      'fecha.required'       => 'Falta la fecha',
      'fecha.date_format'    => 'Fecha incorrecta'
    ];
  }
}
