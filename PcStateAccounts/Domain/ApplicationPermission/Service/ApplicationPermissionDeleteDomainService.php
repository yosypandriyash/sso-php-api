<?php

namespace Core\Domain\ApplicationPermission\Service;

use Core\Domain\Application\Exception\ApplicationNotFoundException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\ApplicationPermission\Exception\ApplicationPermissionNotFoundException;
use Core\Domain\ApplicationPermission\Exception\CouldNotDeleteApplicationPermissionException;
use Core\Domain\ApplicationPermission\Exception\CouldNotSaveApplicationPermissionException;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\BaseDomainService;

class ApplicationPermissionDeleteDomainService extends BaseDomainService {

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
     * @throws ApplicationPermissionNotFoundException
     * @throws CouldNotDeleteApplicationPermissionException
     */
    public function deleteApplicationPermission(
        string $applicationUniqueId,
        string $permissionUniqueId
    ): void
    {
        $application = $this->applicationRepository->getApplicationByUniqueId($applicationUniqueId);

        if (!$application) {
            throw new ApplicationNotFoundException();
        }

        $applicationPermission = $this->applicationPermissionRepository->getOneByUniqueId(
            $permissionUniqueId
        );

        if (!$applicationPermission) {
            throw new ApplicationPermissionNotFoundException();
        }

        try {

            $applicationPermission->setIsDeleted(true);
            $this->applicationPermissionRepository->saveEntity($applicationPermission);

        } catch (\Exception $exception) {
            throw new CouldNotDeleteApplicationPermissionException();
        }
    }
}