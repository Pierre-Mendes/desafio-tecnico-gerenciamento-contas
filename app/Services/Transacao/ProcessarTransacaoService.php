<?php

namespace App\Services\Transacao;

use App\DTOs\ContaDTO;
use App\DTOs\TransacaoDTO;
use App\Exceptions\Conta\ContaNaoEncontradaException;
use App\Exceptions\Transacao\SaldoInsuficienteException;
use App\Factories\TransacaoPorTipoPagamentoFactory;
use App\Repositories\Conta\ContaRepositoryInterface;

readonly class ProcessarTransacaoService
{
    public function __construct(
        private ContaRepositoryInterface         $contaRepository,
        private TransacaoPorTipoPagamentoFactory $transacaoPorTipoPagamentoFactory
    ) {}

    /**
     * @throws SaldoInsuficienteException
     * @throws ContaNaoEncontradaException
     */
    public function execute(TransacaoDTO $transacaoDTO): ContaDTO
    {
        $conta = $this->contaRepository->encontrarPorNumero($transacaoDTO->numeroConta);

        if (!$conta) {
            throw new ContaNaoEncontradaException($transacaoDTO->numeroConta);
        }

        $strategy = $this->transacaoPorTipoPagamentoFactory->criar($transacaoDTO->formaPagamento);
        $valorComTaxa = $strategy->calcularTaxa($transacaoDTO->valor);

        if ($conta->saldo < $valorComTaxa) {
            throw new SaldoInsuficienteException($transacaoDTO->numeroConta);
        }

        $novoSaldo = round($conta->saldo - $valorComTaxa, 2);

        $this->contaRepository->atualizarSaldo(
            $transacaoDTO->numeroConta,
            $novoSaldo
        );

        return new ContaDTO(
            numeroConta: $transacaoDTO->numeroConta,
            saldo: $novoSaldo
        );
    }
}
