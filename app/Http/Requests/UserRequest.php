<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'name'=>'required|string|max:20',
            'cpf'=>'required|regex:/^\d+$/|min:11|max:11|unique:users,cpf',
            'email' => 'required|email|max:25|unique:users,email',
            'password'=>'required|string|min:5',
            'birth_date'=>'required|date',
            'registration_date'=>'required|date',
            'path_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address.cep' => 'required|string|max:9',
            'address.state' => 'required|string|max:2',
            'address.city' => 'required|string|max:30',
            'address.neighborhood' => 'required|string|max:20',
            'address.street' => 'required|string|max:20',
            'address.number' => 'required|string|max:5',
            'address.complement' => 'nullable|string|max:30',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], 422)
        );
    }
}
