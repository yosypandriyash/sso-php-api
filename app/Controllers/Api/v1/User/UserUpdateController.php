<?php

namespace App\Controllers\Api\v1\User;

use App\Constraint\EmailConstraint;
use App\Constraint\FullNameConstraint;
use App\Constraint\PasswordConstraint;
use App\Constraint\UserNameConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Persistence\MySql\User\MySqlUserRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\User\Update\UserUpdate\UserUpdateRequest;
use Core\Application\User\Update\UserUpdate\UserUpdateService;

class UserUpdateController extends UserApiController {

    protected array $requestParameters = [
        'email' => [null, EmailConstraint::class],
        'username' => [null, UserNameConstraint::class],
        'fullName' => [null, FullNameConstraint::class],
        'password' => [null, PasswordConstraint::class]
    ];

    public function index($userUniqueId): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters(
            ['userUniqueId' => $userUniqueId]
        );

        try {
            $validationResult = $this->validateFields($bodyParams, $this->requestParameters);

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $applicationServiceResponse = (new UserUpdateService(
                new MySqlUserRepository()
            ))->execute(
                UserUpdateRequest::create(
                    $bodyParams['userUniqueId'],
                    $bodyParams['email'],
                    $bodyParams['username'],
                    $bodyParams['fullName'],
                    $bodyParams['password'],
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
            $success ? 'USER_UPDATE_SUCCESS' : 'USER_UPDATE_ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}