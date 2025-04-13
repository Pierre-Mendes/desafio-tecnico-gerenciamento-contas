<?php

namespace App\Repositories\Conta;

use App\DTOs\ContaDTO;

interface ContaRepositoryInterface
{
    public function criar(ContaDTO $contaDTO): ContaDTO;

    public function atualizarSaldo(int $numeroConta, float $novoSaldo): bool;

    public function existeNumeroConta(int $numeroConta): bool;

    public function encontrarPorNumero(int $numeroConta): ?ContaDTO;
}
