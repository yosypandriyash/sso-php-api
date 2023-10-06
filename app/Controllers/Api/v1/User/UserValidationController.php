<?php

namespace App\Controllers\Api\v1\User;

use App\Constraint\Application\AppUniqueIdConstraint;
use App\Constraint\Application\ApplicationApiKeyConstraint;
use App\Constraint\User\EmailConstraint;
use App\Constraint\User\PasswordConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use App\Persistence\MySql\ApplicationUser\MySqlApplicationUserRepository;
use App\Persistence\MySql\User\MySqlUserRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\User\Validate\UserValidation\UserValidationRequest;
use Core\Application\User\Validate\UserValidation\UserValidationService;

class UserValidationController extends UserApiController {

    protected array $requestParameters = [
        'applicationId' => AppUniqueIdConstraint::class,
        'applicationApiKey' => ApplicationApiKeyConstraint::class,
        'email' => EmailConstraint::class,
        'password' => PasswordConstraint::class
    ];

    public function index(): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters();

        try {
            $validationResult = $this->validateFields($bodyParams, $this->requestParameters);

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $applicationServiceResponse = (new UserValidationService(
                new MySqlUserRepository(),
                new MySqlApplicationRepository(),
                new MySqlApplicationUserRepository()
            ))->execute(
                UserValidationRequest::create(
                    $bodyParams['applicationId'],
                    $bodyParams['applicationApiKey'],
                    $bodyParams['email'],
                    $bodyParams['password']
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
            $success ? 'USER_VALIDATION_SUCCESS' : 'USER_VALIDATION_ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}