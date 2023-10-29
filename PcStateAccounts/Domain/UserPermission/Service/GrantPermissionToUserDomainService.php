<?php

namespace Core\Domain\UserPermission\Service;

use Core\Domain\ApplicationPermission\Exception\ApplicationPermissionNotFoundException;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\BaseDomainService;
use Core\Domain\Helpers\StringHelperInterface;
use Core\Domain\User\Exception\UserNotFoundException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\UserPermission\Exception\UserPermissionAssignedYetException;
use Core\Domain\UserPermission\Infrastructure\UserPermissionRepositoryInterface;
use Core\Domain\UserPermission\UserPermission;

class GrantPermissionToUserDomainService extends BaseDomainService {

    private const PERMISSION_IS_GRANTED_BY_DEFAULT = true;

    private StringHelperInterface $stringHelper;
    private UserRepositoryInterface $userRepository;
    private UserPermissionRepositoryInterface $userPermissionRepository;
    private ApplicationPermissionRepositoryInterface $applicationPermissionRepository;
    public function __construct(
        StringHelperInterface $stringHelper,
        UserRepositoryInterface $userRepository,
        UserPermissionRepositoryInterface $userPermissionRepository,
        ApplicationPermissionRepositoryInterface $applicationPermissionRepository
    )
    {
        $this->stringHelper = $stringHelper;
        $this->userRepository = $userRepository;
        $this->userPermissionRepository = $userPermissionRepository;
        $this->applicationPermissionRepository = $applicationPermissionRepository;
    }

    /**
     * @throws UserNotFoundException
     * @throws ApplicationPermissionNotFoundException
     * @throws UserPermissionAssignedYetException
     */
    public function grantPermissionToUser(
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
        $match = $this->userPermissionRepository->findByUserAndPermission(
            $user,
            $applicationPermission
        );

        if ($match !== null) {
            if ($match->isGranted()) {
                throw new UserPermissionAssignedYetException();

            } else {
                $userPermission = $match;
                $match->setIsGranted(true);
            }
        } else {

            $userPermissionUniqueId = $this->stringHelper->getRandomString(UserPermission::UNIQUE_ID_LENGTH);

            $userPermission = UserPermission::create(
                null,
                $userPermissionUniqueId,
                $user,
                $applicationPermission,
                self::PERMISSION_IS_GRANTED_BY_DEFAULT
            );
        }

        try {

            $this->userPermissionRepository->saveEntity($userPermission);

        } catch (\Exception $exception) {

            return false;
        }

        return true;
    }
}