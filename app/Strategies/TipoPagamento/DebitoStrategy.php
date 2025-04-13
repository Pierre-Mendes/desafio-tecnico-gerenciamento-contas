<?php

namespace App\Strategies\TipoPagamento;

use App\Enums\TiposPagamento;
use App\Strategies\TipoPagamento\TipoPagamentoStrategy;

class DebitoStrategy implements TipoPagamentoStrategy
{
    public function calcularTaxa(float $valorTransacao): float
    {
        return TiposPagamento::DEBITO->calcularValorComTaxa($valorTransacao);
    }
}
