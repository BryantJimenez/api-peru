<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeStoreRequest extends FormRequest
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
    return [
      'name' => 'required|string|min:2|max:191',
      'limit' => 'nullable|numeric|min:1',
      'qty_mac' => 'required|numeric|min:1'
    ];
  }
}
