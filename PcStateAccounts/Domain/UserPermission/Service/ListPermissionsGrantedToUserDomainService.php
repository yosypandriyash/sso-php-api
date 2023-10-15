<?php

namespace Core\Domain\UserPermission\Service;

use Core\Domain\Application\Exception\ApplicationNotFoundException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\BaseDomainService;
use Core\Domain\User\Exception\UserNotFoundException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\UserPermission\Infrastructure\UserPermissionRepositoryInterface;

class ListPermissionsGrantedToUserDomainService extends BaseDomainService {

    private UserRepositoryInterface $userRepository;
    private UserPermissionRepositoryInterface $userPermissionRepository;
    private ApplicationRepositoryInterface $applicationRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPermissionRepositoryInterface $userPermissionRepository,
        ApplicationRepositoryInterface $applicationRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userPermissionRepository = $userPermissionRepository;
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * @throws UserNotFoundException
     * @throws ApplicationNotFoundException
     */
    public function getGrantedPermissions(
        string $userUniqueId,
        string $applicationUniqueID
    ): array
    {
        $user = $this->userRepository->getOneByUniqueId($userUniqueId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $application = $this->applicationRepository->getApplicationByUniqueId($applicationUniqueID);
        if (!$application) {
            throw new ApplicationNotFoundException();
        }

        $grantedPermissions = $this->userPermissionRepository->getUserPermissionsByApplication(
            $user,
            $application
        );

        return $grantedPermissions->toArray();
    }
}