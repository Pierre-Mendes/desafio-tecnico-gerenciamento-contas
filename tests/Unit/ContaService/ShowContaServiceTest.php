<?php

namespace tests\Unit\ContaService;

use App\DTOs\ContaDTO;
use App\Exceptions\Conta\ContaNaoEncontradaException;
use App\Repositories\Conta\ContaRepositoryInterface;
use App\Services\Conta\ShowContaService;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class ShowContaServiceTest extends TestCase
{
    /**
     * @throws ContaNaoEncontradaException
     * @throws Exception
     */
    public function test_deve_retornar_conta_existente(): void
    {
        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')
            ->willReturn(new ContaDTO(12345, 100.00));

        $service = new ShowContaService($repositoryMock);
        $result = $service->execute(12345);

        $this->assertEquals(12345, $result->numeroConta);
    }

    /**
     * @throws Exception
     */
    public function test_deve_lancar_excecao_para_conta_inexistente(): void
    {
        $this->expectException(ContaNaoEncontradaException::class);

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')
            ->willReturn(null);

        $service = new ShowContaService($repositoryMock);
        $service->execute(99999);
    }

    /**
     * @throws Exception
     */
    public function test_deve_chamar_repositorio_com_numero_correto(): void
    {
        $numeroContaTeste = 99999;

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('encontrarPorNumero')
            ->with($numeroContaTeste)
            ->willReturn(null);

        $service = new ShowContaService($repositoryMock);
        $this->expectException(ContaNaoEncontradaException::class);
        $service->execute($numeroContaTeste);
    }

    /**
     * @throws Exception
     */
    public function test_excecao_deve_ter_codigo_status_404(): void
    {
        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')
            ->willReturn(null);

        $service = new ShowContaService($repositoryMock);

        try {
            $service->execute(99999);
            $this->fail('Deveria ter lançado ContaNaoEncontradaException');
        } catch (ContaNaoEncontradaException $e) {
            $this->assertEquals(StatusCodeInterface::STATUS_NOT_FOUND, $e->getCode());
        }
    }

    /**
     * @throws Exception
     * @throws ContaNaoEncontradaException
     */
    public function test_nao_deve_modificar_conta_retornada_pelo_repositorio(): void
    {
        $contaDTOOriginal = new ContaDTO(
            numeroConta: 12345,
            saldo: 1000.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('encontrarPorNumero')
            ->willReturn($contaDTOOriginal);

        $service = new ShowContaService($repositoryMock);
        $resultado = $service->execute(12345);

        $this->assertSame($contaDTOOriginal, $resultado);
    }
}
