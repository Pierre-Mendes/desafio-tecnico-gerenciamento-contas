<?php

namespace App\Exceptions\Conta;

use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\JsonResponse;

class ContaNaoEncontradaException extends Exception
{
    public function __construct(
        public readonly int $numeroConta,
        string $message = "Conta não encontrada",
        int $code = StatusCodeInterface::STATUS_NOT_FOUND
    ) {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'numero_conta' => $this->numeroConta
        ], $this->getCode());
    }
}
