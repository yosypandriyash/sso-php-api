<?php

namespace App\Controllers\Api\v1\User;

use App\Constraint\Application\ApplicationApiKeyConstraint;
use App\Constraint\Application\AppUniqueIdConstraint;
use App\Constraint\User\EmailConstraint;
use App\Constraint\User\FullNameConstraint;
use App\Constraint\User\PasswordConstraint;
use App\Constraint\User\UserNameConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Helpers\StringHelper;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use App\Persistence\MySql\ApplicationUser\MySqlApplicationUserRepository;
use App\Persistence\MySql\User\MySqlUserRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\User\Create\UserRegistrationRequest;
use Core\Application\User\Create\UserRegistrationService;

class UserRegistrationController extends UserApiController {

    protected array $requestParameters = [
        'applicationId' => AppUniqueIdConstraint::class,
        'applicationApiKey' => ApplicationApiKeyConstraint::class,
        'email' => EmailConstraint::class,
        'username' => UserNameConstraint::class,
        'fullName' => FullNameConstraint::class,
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

            $applicationServiceResponse = (new UserRegistrationService(
                new MySqlUserRepository(),
                new MySqlApplicationRepository(),
                new MySqlApplicationUserRepository(),
                new StringHelper(),
            ))->execute(
                UserRegistrationRequest::create(
                    $bodyParams['applicationId'],
                    $bodyParams['applicationApiKey'],
                    $bodyParams['email'],
                    $bodyParams['username'],
                    $bodyParams['fullName'],
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
            $success ? 'USER_REGISTERED_SUCCESSFULLY' : 'ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}