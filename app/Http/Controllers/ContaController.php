<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ContaRequest;
use App\Http\Requests\BuscarContaRequest;
use App\Services\Conta\CreateContaService;
use App\Services\Conta\ShowContaService;
use App\Exceptions\Conta\ContaNaoEncontradaException;
use Fig\Http\Message\StatusCodeInterface;

class ContaController extends Controller
{
    public function __construct(
        private readonly CreateContaService $createContaService,
        private readonly ShowContaService $showContaService
    ) {}

    /**
     * Cria uma nova conta.
     *
     * @OA\Post(
     *     path="/conta",
     *     summary="Cria uma nova conta",
     *     tags={"Conta"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Informações para criação da conta",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"numero_conta", "saldo"},
     *             @OA\Property(property="numero_conta", type="integer", example=123456),
     *             @OA\Property(property="saldo", type="number", example=1000.50)
     *         )
     *     )
     * )
     *
     * @Response({
     *     code: 201,
     *     description: "Conta criada com sucesso",
     *     ref: Conta
     * })
     *
     *
     * @Response({
     *      code: 422,
     *      description: "Erro de validação de campos ou Conta já existente",
     *      ref: Conta
     *  })
     */
    public function create(ContaRequest $request): JsonResponse
    {
        try {
            $contaDTO = $this->createContaService->execute($request->validated());
            return response()->json($contaDTO->toArray(), StatusCodeInterface::STATUS_CREATED);
        } catch (\DomainException | \InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], StatusCodeInterface::STATUS_BAD_REQUEST);
        }
    }

    /**
     * Exibe os dados de uma conta existente.
     *
     * @OA\Get(
     *     path="/conta/{numero_conta}",
     *     summary="Exibe os dados da conta",
     *     tags={"Conta"},
     *     @OA\Parameter(
     *         name="numero_conta",
     *         in="path",
     *         description="Número da conta a ser buscada",
     *         required=true,
     *         @OA\Schema(type="integer", example=123456)
     *     )
     * )
     *
     * @Response({
     *     code: 200,
     *     description: "Dados da conta retornados com sucesso",
     *     ref: Conta
     * })
     *
     * @Response({
     *     code: 404,
     *     description: "Conta não encontrada",
     *     ref: Conta
     * })
     *
     * @throws ContaNaoEncontradaException
     */
    public function show(BuscarContaRequest $request): JsonResponse
    {
        $contaDTO = $this->showContaService->execute($request->validated()['numero_conta']);
        return response()->json($contaDTO->toArray());
    }
}
