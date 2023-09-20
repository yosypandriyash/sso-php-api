<?php

namespace App\Controllers\Api\v1;

use App\Constraint\BaseConstraint;
use App\Constraint\ConstraintValidation;
use App\Controllers\Api\v1\Exception\BadRequestException;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

abstract class ApiController extends BaseController {

    protected array $requestParameters;

    protected function validateFields(
        array $requestFields = [],
        array $validationInvokableClasses = []
    ): ConstraintValidation
    {
        $validationResult = ConstraintValidation::create([]);

        foreach ($requestFields as $requestFieldName => $requestFieldValue) {
            if (isset($validationInvokableClasses[$requestFieldName])) {

                /** @var BaseConstraint $validationClass */
                $validationClass = new $validationInvokableClasses[$requestFieldName];

                if (!$validationClass->validateField($requestFieldValue)) {
                    $validationResult->add($validationClass->getExceptionMessage());
                }
            }
        }

        return $validationResult;
    }

    protected function retrieveBodyRequestParameters(array $mergeInto = []): array
    {
        foreach ($this->requestParameters as $parameterName => $parameterConstraint) {
            if (isset($mergeInto[$parameterName])) {
                continue;
            }

            $mergeInto[$parameterName] = $this->request->getPost($parameterName) ?? null;
        }

        return $mergeInto;
    }


    protected function response(XhrResponse $response): ResponseInterface
    {
        $this->response->setStatusCode(
            $response->getHttpStatusCode(),
            $response->getStatusKey()
        );

        $this->response->setJSON($response->toJson());
        return $this->response;
    }

    protected function constraintViolationResponse(ConstraintValidation $validationResult): ResponseInterface
    {
        $apiResponse = new XhrResponse();
        return $this->response(
            $apiResponse->setResponseStatus(
                new BadRequestException()
            )->setServerException(
                $validationResult->getValidationErrors()
            )
        );
    }
}