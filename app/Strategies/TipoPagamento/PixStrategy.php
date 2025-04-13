<?php

namespace App\Strategies\TipoPagamento;

use App\Enums\TiposPagamento;
use App\Strategies\TipoPagamento\TipoPagamentoStrategy;

class PixStrategy implements TipoPagamentoStrategy
{
    public function calcularTaxa(float $valorTransacao): float
    {
        return TiposPagamento::PIX->calcularValorComTaxa($valorTransacao);
    }
}
