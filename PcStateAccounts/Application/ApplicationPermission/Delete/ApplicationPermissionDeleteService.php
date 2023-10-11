<?php

namespace Core\Application\ApplicationPermission\Delete;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationValidationDomainService;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\ApplicationPermission\Service\ApplicationPermissionDeleteDomainService;

class ApplicationPermissionDeleteService implements ApplicationServiceInterface {

    private ApplicationValidationDomainService $applicationValidationDomainService;

    private ApplicationPermissionDeleteDomainService $applicationPermissionDeleteDomainService;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        ApplicationPermissionRepositoryInterface $applicationPermissionRepository
    )
    {
        $this->applicationValidationDomainService = new ApplicationValidationDomainService(
            $applicationRepository
        );

        $this->applicationPermissionDeleteDomainService = new ApplicationPermissionDeleteDomainService(
            $applicationRepository,
            $applicationPermissionRepository
        );
    }

    /** @var ApplicationPermissionDeleteRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            // Validate API-KEY for requested application
            $this->applicationValidationDomainService->validateApplicationRequest(
                $request->getAppUniqueId(),
                $request->getApiKey()
            );

            // Register Application permission
            $this->applicationPermissionDeleteDomainService->deleteApplicationPermission(
                $request->getAppUniqueId(),
                $request->getPermissionUniqueId()
            );

            return ApplicationPermissionDeleteResponse::create(
                [],
                true
            );

        } catch (\Exception $exception) {
            return ApplicationPermissionDeleteResponse::create([], false, $exception->getMessage());
        }
    }
}