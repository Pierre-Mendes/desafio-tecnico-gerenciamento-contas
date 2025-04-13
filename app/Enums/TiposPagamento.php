<?php

namespace App\Enums;

enum TiposPagamento: string
{
    case PIX = "P";
    case CREDITO = "C";
    case DEBITO = "D";

    private function getTaxaPorTipoPagamento(): float
    {
        return match($this) {
            self::PIX => 0.0,
            self::CREDITO => 0.05,
            self::DEBITO => 0.03,
        };
    }

    public function calcularValorComTaxa(float $valor): float
    {
        return $valor * (1 + $this->getTaxaPorTipoPagamento());
    }
}
