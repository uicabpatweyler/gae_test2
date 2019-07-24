<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaRequest extends FormRequest
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
        'nombre' => [
          'required',
          'min:2',
          'max:30',
          Rule::unique('categorias')->where( function($query) {
            return $query->where('nombre', mb_convert_case($this->nombre,MB_CASE_UPPER,'UTF-8'))
              ->where('parent_id', $this->parent_id);
          })
        ]
      ];
    }
    public function updateRules(){
      return [
        'nombre' => [
          'required',
          'min:2',
          'max:30',
          Rule::unique('categorias')->where( function($query) {
            return $query->where('nombre', mb_convert_case($this->nombre,MB_CASE_UPPER,'UTF-8'))
              ->where('parent_id', $this->parent_id);
          })->ignore($this->categoria->id)
        ]
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
      'nombre.required' => 'Obligatorio',
      'nombre.min'      => 'Mínimo 2 letras',
      'nombre.max'      => 'Máximo 30 letras',
      'nombre.unique'   => 'Esta categoría ya existe'
    ];
  }

}
