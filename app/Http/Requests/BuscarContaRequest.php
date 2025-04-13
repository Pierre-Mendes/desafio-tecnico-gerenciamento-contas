<?php

namespace App\Http\Requests;

use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class BuscarContaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero_conta' => [
                'required',
                'integer',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'numero_conta.required' => 'O número da conta é obrigatório',
            'numero_conta.integer' => 'O número da conta deve ser um valor inteiro',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY)
        );
    }
}