<?php

namespace tests\Unit\ContaService;

use App\DTOs\ContaDTO;
use App\Repositories\Conta\ContaRepositoryInterface;
use App\Services\Conta\CreateContaService;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class CreateContaServiceTest extends TestCase
{
    public function test_deve_criar_conta_com_sucesso(): void
    {
        $dadosConta = [
            'numero_conta' => 12345,
            'saldo' => 1000.0
        ];

        $contaDTOEsperado = new ContaDTO(
            numeroConta: 12345,
            saldo: 1000.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('existeNumeroConta')->willReturn(false);
        $repositoryMock->method('criar')->willReturn($contaDTOEsperado);

        $service = new CreateContaService($repositoryMock);
        $resultado = $service->execute($dadosConta);

        $this->assertInstanceOf(ContaDTO::class, $resultado);
        $this->assertEquals(12345, $resultado->numeroConta);
        $this->assertEquals(1000.0, $resultado->saldo);
    }

    public function test_deve_lancar_excecao_se_conta_existir(): void
    {
        $dadosConta = [
            'numero_conta' => 12345,
            'saldo' => 1000.0
        ];

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('existeNumeroConta')->willReturn(true);

        $service = new CreateContaService($repositoryMock);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Este número de conta já existe!');

        $service->execute($dadosConta);
    }

    /**
     * @throws Exception
     */
    public function test_deve_verificar_existencia_da_conta_antes_de_criar(): void
    {
        $dadosConta = [
            'numero_conta' => 12345,
            'saldo' => 1000.0
        ];

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('existeNumeroConta')
            ->with(12345)
            ->willReturn(false);

        $repositoryMock->method('criar')->willReturn(new ContaDTO(12345, 1000.0));

        $service = new CreateContaService($repositoryMock);
        $service->execute($dadosConta);
    }

    /**
     * @throws Exception
     */
    public function test_deve_chamar_repositorio_para_criar_conta(): void
    {
        $dadosConta = [
            'numero_conta' => 12345,
            'saldo' => 1000.0
        ];

        $contaDTOEsperado = new ContaDTO(
            numeroConta: 12345,
            saldo: 1000.0
        );

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $repositoryMock->method('existeNumeroConta')->willReturn(false);

        $repositoryMock->expects($this->once())
            ->method('criar')
            ->with($this->equalTo($contaDTOEsperado))
            ->willReturn($contaDTOEsperado);

        $service = new CreateContaService($repositoryMock);
        $service->execute($dadosConta);
    }

    /**
     * @throws Exception
     */
    public function test_deve_lancar_excecao_para_dados_invalidos(): void
    {
        $dadosInvalidos = [
            'numero_conta' => 'abc',
            'saldo' => 'mil'
        ];

        $repositoryMock = $this->createMock(ContaRepositoryInterface::class);
        $service = new CreateContaService($repositoryMock);

        $this->expectException(\TypeError::class);
        $service->execute($dadosInvalidos);
    }
}
