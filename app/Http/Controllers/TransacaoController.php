<?php

namespace App\Http\Controllers;

use App\DTOs\TransacaoDTO;
use App\Enums\TiposPagamento;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransacaoRequest;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\Conta\ContaNaoEncontradaException;
use App\Exceptions\Transacao\SaldoInsuficienteException;
use App\Services\Transacao\ProcessarTransacaoService;

class TransacaoController extends Controller
{
    public function __construct(
        private readonly ProcessarTransacaoService $processarTransacaoService
    ) {}

    /**
     * Processa uma transação.
     *
     * @OA\Post(
     *    path="/transacao",
     *      summary="Processa uma transação",
     *      tags={"Transacao"},
     *     @OA\RequestBody(
     *         required=true,
     *          description="Dados da transação a ser processada",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"forma_pagamento", "numero_conta", "valor"},
     *             @OA\Property(property="forma_pagamento", type="TiposPagamentoEnum", example="P"),
     *             @OA\Property(property="numero_conta", type="integer", example=123456),
     *             @OA\Property(property="valor", type="number", example=1000.50)
     *         )
     *     )
     * )
     *
     * @Response({
     *     code: 201,
     *     description: "Transação processada com sucesso",
     *     ref: Transacao
     * })
     *
     * @Response({
     *      code: 404,
     *      description: "Saldo insuficiente ou conta não encontrada",
     *      ref: Transacao
     *  })
     *
     * @throws SaldoInsuficienteException
     * @throws ContaNaoEncontradaException
     */
    public function processarTransacao(TransacaoRequest $request): JsonResponse
    {
        $transacaoDTO = new TransacaoDTO(
            formaPagamento: TiposPagamento::from($request->input('forma_pagamento')),
            numeroConta: $request->input('numero_conta'),
            valor: $request->input('valor')
        );

        $contaAtualizada = $this->processarTransacaoService->execute($transacaoDTO);

        return response()->json([
            'numero_conta' => $contaAtualizada->numeroConta,
            'saldo' => $contaAtualizada->saldo
        ], StatusCodeInterface::STATUS_CREATED);
    }
}
