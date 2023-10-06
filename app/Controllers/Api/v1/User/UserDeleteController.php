<?php

namespace App\Controllers\Api\v1\User;

use App\Constraint\User\UserUniqueIdConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Persistence\MySql\User\MySqlUserRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\User\Update\UserDelete\UserDeleteRequest;
use Core\Application\User\Update\UserDelete\UserDeleteService;

class UserDeleteController extends UserApiController {

    protected array $requestParameters = [
        'userUniqueId' => UserUniqueIdConstraint::class,
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

            $applicationServiceResponse = (new UserDeleteService(
                new MySqlUserRepository()
            ))->execute(
                UserDeleteRequest::create(
                    $bodyParams['userUniqueId']
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
            $success ? 'USER_DELETE_SUCCESS' : 'USER_DELETE_ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}