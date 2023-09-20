<?php

namespace App\Controllers\Api\v1\Response;

use Exception;

class XhrResponse {

    private string $exceptionMessage = "";
    private int $httpStatusCode = 200;
    private string $statusKey = 'OK';
    private string $operationStatusKey = '';
    private array $operationResultData = [];

    public function __construct()
    {
    }

    public function setOperationStatus(
        string $operationStatusKey,
        array $operationResultData = []
    ): XhrResponse {
        $this->operationStatusKey = $operationStatusKey;
        $this->operationResultData = $operationResultData;

        return $this;
    }

    public function setResponseStatus(
        Exception $exception
    ): XhrResponse {
        $this->httpStatusCode = $exception->getCode();
        $this->statusKey = $exception->getMessage();

        return $this;
    }

    public function setServerException(
        array $exceptionMessages
    ): XhrResponse {
        $this->exceptionMessage = json_encode($exceptionMessages);

        return $this;
    }

    public function getExceptionMessage(): string
    {
        return $this->exceptionMessage;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getStatusKey(): string
    {
        return $this->statusKey;
    }

    public function getOperationStatusKey(): string
    {
        return $this->operationStatusKey;
    }

    public function getOperationResultData(): array
    {
        return $this->operationResultData;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode([
            'status' => [
                'exceptionMessage' => $this->exceptionMessage,
                'httpStatusCode' => $this->httpStatusCode,
                'statusKey' => $this->statusKey,
            ],
            'operationResult' => [
                'operationStatusKey' => $this->operationStatusKey,
                'operationResultData' => $this->operationResultData,
            ]
        ]);
    }
}