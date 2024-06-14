<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'=>'required|numeric',
            'name'=>'sometimes|string',
            'cpf'=>'sometimes|string|unique:users,cpf',
            'birth_date'=>'sometimes|date',
            'email' => 'sometimes|email|unique:users,email',
            'password'=>'sometimes|string',
        ];
    }
}
