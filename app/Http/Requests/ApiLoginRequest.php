<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Mac;

class ApiLoginRequest extends FormRequest
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
            'email' => 'required|string|email|min:5|max:191|exists:users,email',
            'password' => 'required|string|min:8',
            'code' => 'nullable|string|min:6|max:6',
            'mac' => ['nullable', new Mac()]
        ];
    }
}
