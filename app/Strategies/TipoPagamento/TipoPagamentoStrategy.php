<?php

namespace App\Strategies\TipoPagamento;

interface TipoPagamentoStrategy
{
    public function calcularTaxa(float $valorTransacao): float;
}
