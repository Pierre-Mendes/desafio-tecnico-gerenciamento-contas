<?php

namespace App\Services\Conta;

use App\DTOs\ContaDTO;
use App\Repositories\Conta\ContaRepositoryInterface;

readonly class CreateContaService
{
    public function __construct(
        private ContaRepositoryInterface $contaRepository
    ) {}

    public function execute(array $dadosConta): ContaDTO
    {
        $contaDTO = new ContaDTO(
            numeroConta: $dadosConta['numero_conta'],
            saldo: $dadosConta['saldo']
        );

        if (!isset($contaDTO->saldo)) {
            throw new \InvalidArgumentException('Saldo é obrigatório.');
        }

        if ($this->contaRepository->existeNumeroConta($contaDTO->numeroConta)) {
            throw new \DomainException('Este número de conta já existe!');
        }

        return $this->contaRepository->criar($contaDTO);
    }
}
