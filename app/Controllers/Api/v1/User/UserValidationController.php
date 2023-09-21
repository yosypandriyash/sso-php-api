<?php

namespace App\Controllers\Api\v1\User;

use App\Constraint\ApplicationApiKeyConstraint;
use App\Constraint\AppUniqueIdConstraint;
use App\Constraint\EmailConstraint;
use App\Constraint\PasswordConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use App\Persistence\MySql\ApplicationUser\MySqlApplicationUserRepository;
use App\Persistence\MySql\User\MySqlUserRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\User\Validate\UserValidation\UserValidationRequest;
use Core\Application\User\Validate\UserValidation\UserValidationService;

class UserValidationController extends UserApiController {

    protected array $requestParameters = [
        'applicationUniqueId' => AppUniqueIdConstraint::class,
        'applicationApiKey' => ApplicationApiKeyConstraint::class,
        'email' => EmailConstraint::class,
        'password' => PasswordConstraint::class
    ];

    public function index($appUniqueId): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters(
            ['applicationUniqueId' => $appUniqueId]
        );

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
                    $bodyParams['applicationUniqueId'],
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