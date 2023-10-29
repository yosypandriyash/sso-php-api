<?php

namespace Core\Domain\ApplicationPermission\Service;

use Core\Domain\Application\Exception\ApplicationNotFoundException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\ApplicationPermission\Exception\ApplicationPermissionSameNameRegisteredException;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\BaseDomainService;
use Core\Domain\Helpers\StringHelperInterface;

class ApplicationPermissionRegistrationDomainService extends BaseDomainService {

    private ApplicationPermissionRepositoryInterface $applicationPermissionRepository;
    private ApplicationRepositoryInterface $applicationRepository;
    private StringHelperInterface $stringHelper;

    public function __construct(
        ApplicationPermissionRepositoryInterface $applicationPermissionRepository,
        ApplicationRepositoryInterface $applicationRepository,
        StringHelperInterface $stringHelper
    )
    {
        $this->applicationPermissionRepository = $applicationPermissionRepository;
        $this->applicationRepository = $applicationRepository;
        $this->stringHelper = $stringHelper;
    }

    public function registerApplicationPermission(
        string $applicationUniqueId,
        string $permissionName,
        string $permissionDescription,
        bool $isActive
    ): ?ApplicationPermission
    {
        $application = $this->applicationRepository->getApplicationByUniqueId(
            $applicationUniqueId
        );

        if (!$application) {
            throw new ApplicationNotFoundException();
        }

        // Search existing application permission by app.id and permission name
        $applicationId = $application->getId()->getValue();

        $existingMatches = $this->applicationPermissionRepository->getCountMatchesByApplicationIdAndPermissionName(
            $applicationId,
            $permissionName
        );

        if ($existingMatches > 0) {
            throw new ApplicationPermissionSameNameRegisteredException();
        }

        $uniqueId = $this->stringHelper->getRandomString(ApplicationPermission::UNIQUE_ID_LENGTH);

        $applicationPermission = ApplicationPermission::create(
            null,
            $uniqueId,
            $application,
            $permissionName,
            $permissionDescription,
            $isActive
        );

        $applicationPermission = $this->applicationPermissionRepository->saveEntity($applicationPermission);

        return $applicationPermission;
    }
}