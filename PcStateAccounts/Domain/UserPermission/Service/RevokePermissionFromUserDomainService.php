<?php

namespace Core\Domain\UserPermission\Service;

use Core\Domain\ApplicationPermission\Exception\ApplicationPermissionNotFoundException;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\BaseDomainService;
use Core\Domain\User\Exception\UserNotFoundException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\UserPermission\Exception\UserPermissionNotAssignedException;
use Core\Domain\UserPermission\Infrastructure\UserPermissionRepositoryInterface;

class RevokePermissionFromUserDomainService extends BaseDomainService {

    private UserRepositoryInterface $userRepository;
    private UserPermissionRepositoryInterface $userPermissionRepository;
    private ApplicationPermissionRepositoryInterface $applicationPermissionRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPermissionRepositoryInterface $userPermissionRepository,
        ApplicationPermissionRepositoryInterface $applicationPermissionRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userPermissionRepository = $userPermissionRepository;
        $this->applicationPermissionRepository = $applicationPermissionRepository;
    }

    /**
     * @throws UserNotFoundException
     * @throws ApplicationPermissionNotFoundException
     * @throws UserPermissionNotAssignedException
     */
    public function revokePermissionFromUser(
        string $userUniqueId,
        string $permissionUniqueId
    ): bool
    {
        $user = $this->userRepository->getOneByUniqueId($userUniqueId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $applicationPermission = $this->applicationPermissionRepository->getOneByUniqueId($permissionUniqueId);

        if (!$applicationPermission) {
            throw new ApplicationPermissionNotFoundException();
        }

        // check that permission was not assigned yet
        $userPermission = $this->userPermissionRepository->findByUserAndPermission(
            $user,
            $applicationPermission
        );

        if (!$userPermission) {
            throw new UserPermissionNotAssignedException();
        }

        $userPermission->setIsGranted(false);

        try {

            $this->userPermissionRepository->saveEntity($userPermission);

        } catch (\Exception $exception) {

            return false;
        }

        return true;
    }
}