<?php

namespace Core\Domain\ApplicationPermission\Service;

use Core\Domain\Application\Exception\ApplicationNotFoundException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\ApplicationPermission\ApplicationPermissionsList;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\BaseDomainService;

class ApplicationPermissionListDomainService extends BaseDomainService {

    private ApplicationRepositoryInterface $applicationRepository;

    private ApplicationPermissionRepositoryInterface $applicationPermissionRepository;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        ApplicationPermissionRepositoryInterface $applicationPermissionRepository
    )
    {
        $this->applicationRepository = $applicationRepository;
        $this->applicationPermissionRepository = $applicationPermissionRepository;
    }

    /**
     * @throws ApplicationNotFoundException
     */
    public function getApplicationPermissions(
        string $applicationUniqueId
    ): ApplicationPermissionsList
    {
        $application = $this->applicationRepository->getApplicationByUniqueId($applicationUniqueId);

        if (!$application) {
            throw new ApplicationNotFoundException();
        }

        return $this->applicationPermissionRepository->getAllApplicationPermissions(
            $application
        );
    }
}