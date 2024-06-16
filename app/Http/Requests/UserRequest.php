<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>'required|string',
            'cpf'=>'required|string|unique:users,cpf',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|string',
            'birth_date'=>'required|date',
            'registration_date'=>'required|date',
            'path_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address.cep' => 'required|string|max:9',
            'address.state' => 'required|string|max:2',
            'address.city' => 'required|string|max:255',
            'address.neighborhood' => 'required|string|max:255',
            'address.street' => 'required|string|max:255',
            'address.number' => 'required|string|max:10',
            'address.complement' => 'nullable|string|max:255',
        ];
    }
}
