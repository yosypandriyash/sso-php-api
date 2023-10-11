<?php

namespace App\Controllers\Api\v1\ApplicationPermission;

use App\Constraint\Application\ApplicationApiKeyConstraint;
use App\Constraint\Application\AppUniqueIdConstraint;
use App\Constraint\Permission\PermissionUniqueIdConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use App\Persistence\MySql\ApplicationPermission\MySqlApplicationPermissionRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\ApplicationPermission\Delete\ApplicationPermissionDeleteRequest;
use Core\Application\ApplicationPermission\Delete\ApplicationPermissionDeleteService;

class ApplicationPermissionDeleteController extends ApplicationPermissionApiController {

    protected array $requestParameters = [
        'applicationUniqueId' => AppUniqueIdConstraint::class,
        'applicationApiKey' => ApplicationApiKeyConstraint::class,
        'permissionUniqueId' => PermissionUniqueIdConstraint::class,
    ];

    public function index(
        string $applicationUniqueId,
        string $permissionUniqueId
    ): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters([
            'applicationUniqueId' => $applicationUniqueId,
            'permissionUniqueId' => $permissionUniqueId
        ]);

        try {
            $validationResult = $this->validateFields($bodyParams, $this->requestParameters);

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $applicationServiceResponse = (new ApplicationPermissionDeleteService(
                new MySqlApplicationRepository(),
                new MySqlApplicationPermissionRepository(),
            ))->execute(
                ApplicationPermissionDeleteRequest::create(
                    $bodyParams['applicationUniqueId'],
                    $bodyParams['applicationApiKey'],
                    $bodyParams['permissionUniqueId'],
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
            $success ? 'PERMISSION_DELETED_SUCCESSFULLY' : 'ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}