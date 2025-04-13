<?php

namespace App\Factories;

use App\Enums\TiposPagamento;
use App\Strategies\TipoPagamento\PixStrategy;
use App\Strategies\TipoPagamento\DebitoStrategy;
use App\Strategies\TipoPagamento\CreditoStrategy;
use App\Strategies\TipoPagamento\TipoPagamentoStrategy;

readonly class TransacaoPorTipoPagamentoFactory
{
    public function __construct(
        private PixStrategy     $pixStrategy,
        private DebitoStrategy  $debitoStrategy,
        private CreditoStrategy $creditoStrategy
    ) {}

    public function criar(TiposPagamento $tipo): TipoPagamentoStrategy
    {
        return match($tipo) {
            TiposPagamento::PIX => $this->pixStrategy,
            TiposPagamento::DEBITO => $this->debitoStrategy,
            TiposPagamento::CREDITO => $this->creditoStrategy,
        };
    }
}
