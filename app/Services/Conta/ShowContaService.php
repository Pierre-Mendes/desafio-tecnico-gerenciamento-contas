<?php

namespace App\Services\Conta;

use App\DTOs\ContaDTO;
use App\Repositories\Conta\ContaRepositoryInterface;
use App\Exceptions\Conta\ContaNaoEncontradaException;

readonly class ShowContaService
{
    public function __construct(
        private ContaRepositoryInterface $contaRepository
    ) {}

    /**
     * @throws ContaNaoEncontradaException
     */
    public function execute(int $numeroConta): ContaDTO
    {
        $contaDTO = $this->contaRepository->encontrarPorNumero($numeroConta);

        if (!$contaDTO) {
            throw new ContaNaoEncontradaException($numeroConta);
        }

        return $contaDTO;
    }
}
