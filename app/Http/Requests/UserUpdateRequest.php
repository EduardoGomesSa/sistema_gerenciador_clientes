<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            "id"=>'required|numeric',
            'name'=>'sometimes|string|max:20',
            'cpf'=>'sometimes|regex:/^\d+$/|max:11|min:11|unique:users,cpf',
            'birth_date'=>'sometimes|date',
            'email' => 'sometimes|email|max:25|unique:users,email',
            'password'=>'sometimes|string|min:5',
            'path_photo' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
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
