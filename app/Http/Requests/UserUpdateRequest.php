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
            'name'=>'sometimes|string',
            'cpf'=>'sometimes|string|unique:users,cpf',
            'birth_date'=>'sometimes|date',
            'email' => 'sometimes|email|unique:users,email',
            'password'=>'sometimes|string',
            'path_photo' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Incluir os dados recebidos na resposta de erro
        $response = response()->json([
            'errors' => $errors,
            'data' => $this->all(), // Aqui você obtém todos os dados recebidos na requisição
        ], 422);

        throw new HttpResponseException($response);
        
        // $errors = $validator->errors();

        // throw new HttpResponseException(
        //     response()->json(['errors' => $errors], 422)
        // );
    }

    
}
