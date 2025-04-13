<?php

namespace App\Exceptions\Transacao;

use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\JsonResponse;

class SaldoInsuficienteException extends Exception
{
    public function __construct(
        public readonly int $numeroConta,
        string $message = "Saldo insuficiente para realizar a transação",
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
