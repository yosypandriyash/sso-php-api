<?php

namespace App\Controllers\Api\v1\UserPermission;

use App\Constraint\Application\ApplicationApiKeyConstraint;
use App\Constraint\Application\AppUniqueIdConstraint;
use App\Constraint\User\UserUniqueIdConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use App\Persistence\MySql\ApplicationPermission\MySqlApplicationPermissionRepository;
use App\Persistence\MySql\ApplicationUser\MySqlApplicationUserRepository;
use App\Persistence\MySql\User\MySqlUserRepository;
use App\Persistence\MySql\UserPermission\MySqlUserPermissionRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\UserPermission\_List\ListPermissionsGrantedToUserRequest;
use Core\Application\UserPermission\_List\ListPermissionsGrantedToUserService;
use Core\Application\UserPermission\Grant\GrantPermissionToUserRequest;

class ListPermissionGrantedToUserController extends UserPermissionApiController {

    protected array $requestParameters = [
        'userUniqueId' => UserUniqueIdConstraint::class,
        'applicationUniqueId' => AppUniqueIdConstraint::class,
        'applicationApiKey' => ApplicationApiKeyConstraint::class
    ];

    public function index($userUniqueId): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters([
            'userUniqueId' => $userUniqueId,
        ]);

        try {
            $validationResult = $this->validateFields($bodyParams, $this->requestParameters);

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $applicationServiceResponse = (new ListPermissionsGrantedToUserService(
                new MySqlUserRepository(),
                new MySqlApplicationRepository(),
                new MySqlUserPermissionRepository(),
                new MySqlApplicationUserRepository(),
                new MySqlApplicationPermissionRepository()
            ))->execute(
                ListPermissionsGrantedToUserRequest::create(
                    $bodyParams['applicationUniqueId'],
                    $bodyParams['applicationApiKey'],
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
            $success ? 'PERMISSIONS_LIST_SUCCESS' : 'PERMISSIONS_LIST_ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}