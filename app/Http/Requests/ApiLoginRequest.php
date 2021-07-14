<?php

namespace App\Http\Requests;

use App\Rules\Mac;
use Illuminate\Foundation\Http\FormRequest;

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
            'mac' => ['required', new Mac()],
            'password' => 'required|string|min:8'
        ];
    }
}
