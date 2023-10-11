<?php

namespace App\Controllers\Api\v1\ApplicationPermission;

use App\Constraint\Application\ApplicationApiKeyConstraint;
use App\Constraint\Application\AppUniqueIdConstraint;
use App\Constraint\Permission\PermissionDescriptionConstraint;
use App\Constraint\Permission\PermissionIsActiveConstraint;
use App\Constraint\Permission\PermissionNameConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Helpers\StringHelper;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use App\Persistence\MySql\ApplicationPermission\MySqlApplicationPermissionRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\ApplicationPermission\Create\ApplicationPermissionRegistrationRequest;
use Core\Application\ApplicationPermission\Create\ApplicationPermissionRegistrationService;

class ApplicationPermissionRegistrationController extends ApplicationPermissionApiController {

    protected array $requestParameters = [
        'applicationUniqueId' => AppUniqueIdConstraint::class,
        'applicationApiKey' => ApplicationApiKeyConstraint::class,
        'permissionName' => PermissionNameConstraint::class,
        'permissionDescription' => [null, PermissionDescriptionConstraint::class],
        'isActive' => PermissionIsActiveConstraint::class
    ];

    public function index($applicationUniqueId): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters([
            'applicationUniqueId' => $applicationUniqueId
        ]);

        try {
            $validationResult = $this->validateFields($bodyParams, $this->requestParameters);

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $applicationServiceResponse = (new ApplicationPermissionRegistrationService(

                new MySqlApplicationRepository(),
                new MySqlApplicationPermissionRepository(),
                new StringHelper(),
            ))->execute(
                ApplicationPermissionRegistrationRequest::create(
                    $bodyParams['applicationUniqueId'],
                    $bodyParams['applicationApiKey'],
                    $bodyParams['permissionName'],
                    $bodyParams['permissionDescription'],
                    $bodyParams['isActive'],
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
            $success ? 'PERMISSION_REGISTERED_SUCCESSFULLY' : 'ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}