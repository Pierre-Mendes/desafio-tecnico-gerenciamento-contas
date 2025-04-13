<?php

namespace App\Http\Requests;

use App\Enums\TiposPagamento;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TransacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'forma_pagamento' => [
                'required',
                'string',
                Rule::in(array_column(TiposPagamento::cases(), 'value'))
            ],
            'numero_conta' => [
                'required',
                'integer',
                'exists:contas,numero_conta'
            ],
            'valor' => [
                'required',
                'numeric',
                'min:0.01',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'forma_pagamento.required' => 'O campo: forma de pagamento é obrigatória',
            'forma_pagamento.in' => 'Forma de pagamento inválida (use P - Pix, C - Crédito ou D - Débito)',

            'numero_conta.required' => 'O campo: número da conta é obrigatório',
            'numero_conta.integer' => 'Número da conta inválido',
            'numero_conta.exists' => 'Conta não encontrada',

            'valor.required' => 'O valor é obrigatório',
            'valor.numeric' => 'O valor deve ser numérico',
            'valor.min' => 'O valor mínimo para realizar uma transação é de: 0.01',
            'valor.regex' => 'O valor deve ter no máximo 2 casas decimais'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();

        $response = response()->json([
            'success' => false,
            'message' => 'Erro',
            'errors' => $errors
        ], StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
