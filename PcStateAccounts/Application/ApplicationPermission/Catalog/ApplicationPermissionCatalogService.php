<?php

namespace Core\Application\ApplicationPermission\Catalog;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationValidationDomainService;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\ApplicationPermission\Service\ApplicationPermissionListDomainService;

class ApplicationPermissionCatalogService implements ApplicationServiceInterface {

    private ApplicationValidationDomainService $applicationValidationDomainService;
    private ApplicationPermissionListDomainService $applicationPermissionListDomainService;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        ApplicationPermissionRepositoryInterface $applicationPermissionRepository
    )
    {
        $this->applicationValidationDomainService = new ApplicationValidationDomainService(
            $applicationRepository
        );

        $this->applicationPermissionListDomainService = new ApplicationPermissionListDomainService(
            $applicationRepository,
            $applicationPermissionRepository
        );
    }

    /** @var ApplicationPermissionCatalogRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            // Validate API-KEY for requested application
            $this->applicationValidationDomainService->validateApplicationRequest(
                $request->getAppUniqueId(),
                $request->getApiKey()
            );

            $applicationPermissions = $this->applicationPermissionListDomainService->getApplicationPermissions(
                $request->getAppUniqueId()
            );

            return ApplicationPermissionCatalogResponse::create(
                array_map(function($applicationPermission) {
                    /** @var ApplicationPermission $applicationPermission */
                    return [
                        'uniqueId' => $applicationPermission->getUniqueId(),
                        'permissionName' => $applicationPermission->getPermissionName(),
                        'permissionDescription' => $applicationPermission->getPermissionDescription(),
                        'active' => $applicationPermission->isActive()
                    ];
                }, $applicationPermissions->toArray()),
                true
            );

        } catch (\Exception $exception) {
            return ApplicationPermissionCatalogResponse::create([], false, $exception->getMessage());
        }
    }
}