<?php

namespace App\Http\Requests;

use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContaRequest extends FormRequest
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
                'digits_between:3,12',
                'unique:contas,numero_conta'
            ],
            'saldo' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'numero_conta.required' => 'O número da conta é obrigatório',
            'numero_conta.integer' => 'O número da conta deve ser um valor inteiro',
            'numero_conta.digits_between' => 'O número da conta deve ter entre 3 e 12 dígitos',
            'numero_conta.unique' => 'Este número de conta já está em uso',

            'saldo.required' => 'O campo saldo é obrigatório',
            'saldo.numeric' => 'O valor do saldo deve ser numérico',
            'saldo.min' => 'O valor do saldo não pode ser negativo',
            'saldo.regex' => 'O saldo deve ter no máximo 2 casas decimais',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();

        $response = response()->json([
            'success' => false,
            'message' => 'Erro de validação de campos',
            'errors' => $errors
        ], StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
