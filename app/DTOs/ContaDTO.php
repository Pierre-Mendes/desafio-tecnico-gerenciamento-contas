<?php

namespace App\DTOs;

class ContaDTO implements \JsonSerializable
{
    public function __construct(
        public int $numeroConta,
        public float $saldo
    ) {}

    public function toArray(): array
    {
        return [
            'numero_conta' => $this->numeroConta,
            'saldo' => $this->saldo
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
