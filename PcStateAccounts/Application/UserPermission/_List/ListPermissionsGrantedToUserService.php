<?php

namespace Core\Application\UserPermission\_List;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationValidationDomainService;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Core\Domain\ApplicationUser\Service\ApplicationUserValidationDomainService;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\UserPermission\Infrastructure\UserPermissionRepositoryInterface;
use Core\Domain\UserPermission\Service\ListPermissionsGrantedToUserDomainService;

class ListPermissionsGrantedToUserService implements ApplicationServiceInterface {

    private ApplicationValidationDomainService $applicationValidationDomainService;
    private ApplicationUserValidationDomainService $applicationUserValidationDomainService;

    private ListPermissionsGrantedToUserDomainService $listPermissionsGrantedToUserDomainService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ApplicationRepositoryInterface $applicationRepository,
        UserPermissionRepositoryInterface $userPermissionRepository,
        ApplicationUserRepositoryInterface $applicationUserRepository,
        ApplicationPermissionRepositoryInterface $applicationPermissionRepository
    )
    {
        $this->applicationValidationDomainService = new ApplicationValidationDomainService(
            $applicationRepository
        );

        $this->applicationUserValidationDomainService = new ApplicationUserValidationDomainService(
            $applicationUserRepository
        );

        $this->listPermissionsGrantedToUserDomainService = new ListPermissionsGrantedToUserDomainService(
            $userRepository,
            $userPermissionRepository,
            $applicationRepository
        );

    }

    /** @var ListPermissionsGrantedToUserRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {

            $this->applicationValidationDomainService->validateApplicationRequest(
                $request->getApplicationUniqueId(),
                $request->getApiKey()
            );

            $this->applicationUserValidationDomainService->validateUserBelongsToApplication(
                $request->getApplicationUniqueId(),
                $request->getUserUniqueId()
            );

            $result = $this->listPermissionsGrantedToUserDomainService->getGrantedPermissions(
                $request->getUserUniqueId(),
                $request->getApplicationUniqueId()
            );

            return ListPermissionsGrantedToUserResponse::create(
                $result,
                true
            );

        } catch (\Exception $exception) {

            return ListPermissionsGrantedToUserResponse::create(
                [], false, $exception->getMessage()
            );
        }
    }
}