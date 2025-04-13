<?php

namespace App\DTOs;

use App\Enums\TiposPagamento;

class TransacaoDTO
{
    public function __construct(
        public TiposPagamento $formaPagamento,
        public int $numeroConta,
        public float $valor
    ) {}

    public function toArray(): array
    {
        return [
            'forma_pagamento' => $this->formaPagamento->value,
            'numero_conta' => $this->numeroConta,
            'valor' => $this->valor
        ];
    }
}
