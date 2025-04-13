<?php

namespace App\Repositories\Conta;

use App\Models\Conta;
use App\DTOs\ContaDTO;
use App\Repositories\Conta\ContaRepositoryInterface;

class ContaRepositoryDatabase implements ContaRepositoryInterface
{
    public function criar(ContaDTO $contaDTO): ContaDTO
    {
        $conta = Conta::create([
            'numero_conta' => $contaDTO->numeroConta,
            'saldo' => $contaDTO->saldo
        ]);

        return new ContaDTO(
            numeroConta: $conta->numero_conta,
            saldo: $conta->saldo
        );
    }

    public function encontrarPorNumero(int $numeroConta): ?ContaDTO
    {
        $conta = Conta::where('numero_conta', $numeroConta)->first();

        return $conta ? new ContaDTO(
            numeroConta: $conta->numero_conta,
            saldo: $conta->saldo
        ) : null;
    }

    public function atualizarSaldo(int $numeroConta, float $novoSaldo): bool
    {
        return Conta::where('numero_conta', $numeroConta)
                ->update(['saldo' => $novoSaldo]) > 0;
    }

    public function existeNumeroConta(int $numeroConta): bool
    {
        return Conta::where('numero_conta', $numeroConta)->exists();
    }
}
