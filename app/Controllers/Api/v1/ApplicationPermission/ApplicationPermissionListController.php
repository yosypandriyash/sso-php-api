<?php

namespace App\Controllers\Api\v1\ApplicationPermission;

use App\Constraint\Application\ApplicationApiKeyConstraint;
use App\Constraint\Application\AppUniqueIdConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use App\Persistence\MySql\ApplicationPermission\MySqlApplicationPermissionRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\ApplicationPermission\Catalog\ApplicationPermissionCatalogRequest;
use Core\Application\ApplicationPermission\Catalog\ApplicationPermissionCatalogService;

class ApplicationPermissionListController extends ApplicationPermissionApiController {

    protected array $requestParameters = [
        'applicationUniqueId' => AppUniqueIdConstraint::class,
        'applicationApiKey' => ApplicationApiKeyConstraint::class
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

            $applicationServiceResponse = (new ApplicationPermissionCatalogService(
                new MySqlApplicationRepository(),
                new MySqlApplicationPermissionRepository()
            ))->execute(
                ApplicationPermissionCatalogRequest::create(
                    $bodyParams['applicationUniqueId'],
                    $bodyParams['applicationApiKey']
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