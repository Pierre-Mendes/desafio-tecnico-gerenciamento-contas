<?php

namespace tests\Unit\ProcessarTransacaoService;

use App\DTOs\ContaDTO;
use App\DTOs\TransacaoDTO;
use App\Enums\TiposPagamento;
use App\Exceptions\Conta\ContaNaoEncontradaException;
use app\Exceptions\Transacao\SaldoInsuficienteException;
use App\Factories\TransacaoPorTipoPagamentoFactory;
use App\Repositories\Conta\ContaRepositoryInterface;
use App\Services\Transacao\ProcessarTransacaoService;
use App\Strategies\TipoPagamento\CreditoStrategy;
use App\Strategies\TipoPagamento\DebitoStrategy;
use App\Strategies\TipoPagamento\PixStrategy;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class ProcessarTransacaoServiceTest extends TestCase
{
    /**
     * @throws SaldoInsuficienteException
     * @throws Exception
     * @throws ContaNaoEncontradaException
     */
    public function test_deve_processar_transacao_pix_com_sucesso(): void
    {
        $contaExistente = new ContaDTO(12345, 100.0);
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::PIX,
            numeroConta: 12345,
            valor: 50.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')
            ->with(12345)
            ->willReturn($contaExistente);
        $repositoryMock->expects($this->once())
            ->method('atualizarSaldo')
            ->with(12345, 50.0);

        $factoryMock = $this->createMock(TransacaoPorTipoPagamentoFactory::class);
        $factoryMock->method('criar')
            ->willReturn(new PixStrategy());

        $service = new ProcessarTransacaoService($repositoryMock, $factoryMock);
        $resultado = $service->execute($transacaoDTO);
        $this->assertEquals(12345, $resultado->numeroConta);
        $this->assertEquals(50.0, $resultado->saldo);
    }

    /**
     * @throws SaldoInsuficienteException
     * @throws Exception
     * @throws ContaNaoEncontradaException
     */
    public function test_deve_processar_transacao_debito_com_taxa(): void
    {
        $contaExistente = new ContaDTO(12345, 100.0);
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::DEBITO,
            numeroConta: 12345,
            valor: 50.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')->willReturn($contaExistente);
        $repositoryMock->expects($this->once())
            ->method('atualizarSaldo')
            ->with(12345, 48.5);

        $factoryMock = $this->createMock(TransacaoPorTipoPagamentoFactory::class);
        $factoryMock->method('criar')
            ->willReturn(new DebitoStrategy());

        $service = new ProcessarTransacaoService($repositoryMock, $factoryMock);
        $resultado = $service->execute($transacaoDTO);
        $this->assertEquals(48.5, $resultado->saldo);
    }

    /**
     * @throws SaldoInsuficienteException
     * @throws Exception
     * @throws ContaNaoEncontradaException
     */
    public function test_deve_processar_transacao_credito_com_taxa(): void
    {
        $contaExistente = new ContaDTO(12345, 110.0);
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::CREDITO,
            numeroConta: 12345,
            valor: 50.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')->willReturn($contaExistente);
        $repositoryMock->expects($this->once())
            ->method('atualizarSaldo')
            ->with(12345, 58.5);

        $factoryMock = $this->createMock(TransacaoPorTipoPagamentoFactory::class);
        $factoryMock->method('criar')
            ->willReturn(new DebitoStrategy());

        $service = new ProcessarTransacaoService($repositoryMock, $factoryMock);
        $resultado = $service->execute($transacaoDTO);
        $this->assertEquals(58.5, $resultado->saldo);
    }

    /**
     * @throws SaldoInsuficienteException
     * @throws Exception
     */
    public function test_deve_lancar_excecao_se_conta_nao_existir(): void
    {
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::PIX,
            numeroConta: 99999,
            valor: 10.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')
            ->with(99999)
            ->willReturn(null);

        $factoryMock = $this->createMock(TransacaoPorTipoPagamentoFactory::class);
        $service = new ProcessarTransacaoService($repositoryMock, $factoryMock);
        $this->expectException(ContaNaoEncontradaException::class);
        $this->expectExceptionMessage('Conta não encontrada');
        $service->execute($transacaoDTO);
    }

    /**
     * @throws Exception
     * @throws ContaNaoEncontradaException
     */
    public function test_deve_lancar_excecao_se_saldo_insuficiente(): void
    {
        $contaExistente = new ContaDTO(12345, 10.0);
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::CREDITO,
            numeroConta: 12345,
            valor: 10.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')->willReturn($contaExistente);

        $factoryMock = $this->createMock(TransacaoPorTipoPagamentoFactory::class);
        $factoryMock->method('criar')
            ->willReturn(new CreditoStrategy());

        $service = new ProcessarTransacaoService($repositoryMock, $factoryMock);
        $this->expectException(SaldoInsuficienteException::class);
        $this->expectExceptionMessage('Saldo insuficiente para realizar a transação');
        $service->execute($transacaoDTO);
    }

    /**
     * @throws SaldoInsuficienteException
     * @throws Exception
     * @throws ContaNaoEncontradaException
     */
    public function test_deve_chamar_factory_com_forma_pagamento_correta(): void
    {
        $contaExistente = new ContaDTO(12345, 100.0);
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::CREDITO,
            numeroConta: 12345,
            valor: 10.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')->willReturn($contaExistente);

        $factoryMock = $this->createMock(TransacaoPorTipoPagamentoFactory::class);
        $factoryMock->expects($this->once())
            ->method('criar')
            ->with(TiposPagamento::CREDITO)
            ->willReturn(new CreditoStrategy());

        $service = new ProcessarTransacaoService($repositoryMock, $factoryMock);
        $service->execute($transacaoDTO);
    }

    /**
     * @throws SaldoInsuficienteException
     * @throws Exception
     * @throws ContaNaoEncontradaException
     */
    public function test_deve_atualizar_saldo_no_repositorio(): void
    {
        $contaExistente = new ContaDTO(12345, 100.0);
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::PIX,
            numeroConta: 12345,
            valor: 30.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')->willReturn($contaExistente);
        $repositoryMock->expects($this->once())
            ->method('atualizarSaldo')
            ->with(12345, 70.0);

        $factoryMock = $this->createMock(TransacaoPorTipoPagamentoFactory::class);
        $factoryMock->method('criar')->willReturn(new PixStrategy());
        $service = new ProcessarTransacaoService($repositoryMock, $factoryMock);
        $service->execute($transacaoDTO);
    }

    /**
     * @throws SaldoInsuficienteException
     * @throws Exception
     * @throws ContaNaoEncontradaException
     */
    public function test_deve_processar_valores_decimais_corretamente(): void
    {
        $contaExistente = new ContaDTO(12345, 100.37);
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::DEBITO,
            numeroConta: 12345,
            valor: 10.15
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')->willReturn($contaExistente);
        $repositoryMock->expects($this->once())
            ->method('atualizarSaldo')
            ->with(12345, 89.92);

        $factoryMock = $this->createMock(TransacaoPorTipoPagamentoFactory::class);
        $factoryMock->method('criar')->willReturn(new DebitoStrategy());

        $service = new ProcessarTransacaoService($repositoryMock, $factoryMock);
        $resultado = $service->execute($transacaoDTO);
        $this->assertEquals(89.92, $resultado->saldo);
    }
}
