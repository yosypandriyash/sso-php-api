<?php

namespace App\Controllers\Api\v1\Application;

use App\Constraint\ApplicationNameConstraint;
use App\Constraint\UrlConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Helpers\StringHelper;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\Application\Create\ApplicationRegistration\ApplicationRegistrationRequest;
use Core\Application\Application\Create\ApplicationRegistration\ApplicationRegistrationService;

class ApplicationRegistrationController extends ApplicationApiController {

    protected array $requestParameters = [
        'applicationName' => ApplicationNameConstraint::class,
        'url' => UrlConstraint::class,
        'callbackUrl' => UrlConstraint::class,
    ];

    public function index(): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters();

        try {
            $validationResult = $this->validateFields($bodyParams, $this->requestParameters);

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $applicationServiceResponse = (new ApplicationRegistrationService(
                new MySqlApplicationRepository(),
                new StringHelper()
            ))->execute(
                ApplicationRegistrationRequest::create(
                    $bodyParams['applicationName'],
                    $bodyParams['url'],
                    $bodyParams['callbackUrl'],
                )
            );

            $result = $applicationServiceResponse->getResult();
            $success = $applicationServiceResponse->isSuccess();
            $error = $applicationServiceResponse->getErrorMessage();

        } catch (\Exception $exception) {
            $result = [];
            $success = false;
            $error = $exception->getMessage();
        }

        $apiResponse = new XhrResponse();
        $apiResponse->setOperationStatus(
            $success ? 'APPLICATION_REGISTERED_SUCCESSFULLY' : 'ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}