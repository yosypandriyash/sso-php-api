<?php

namespace Core\Application\UserPermission\Grant;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationValidationDomainService;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Core\Domain\ApplicationUser\Service\ApplicationUserValidationDomainService;
use Core\Domain\Helpers\StringHelperInterface;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\UserPermission\Infrastructure\UserPermissionRepositoryInterface;
use Core\Domain\UserPermission\Service\GrantPermissionToUserDomainService;

class GrantPermissionToUserService implements ApplicationServiceInterface {

    private ApplicationValidationDomainService $applicationValidationDomainService;
    private GrantPermissionToUserDomainService $grantPermissionToUserDomainService;
    private ApplicationUserValidationDomainService $applicationUserValidationDomainService;
    public function __construct(
        StringHelperInterface $stringHelper,
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

        $this->grantPermissionToUserDomainService = new GrantPermissionToUserDomainService(
            $stringHelper,
            $userRepository,
            $userPermissionRepository,
            $applicationPermissionRepository
        );

        $this->applicationUserValidationDomainService = new ApplicationUserValidationDomainService(
            $applicationUserRepository
        );

    }

    /** @var GrantPermissionToUserRequest $request */
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

            $success = $this->grantPermissionToUserDomainService->grantPermissionToUser(
                $request->getUserUniqueId(),
                $request->getPermissionUniqueId()
            );

            return GrantPermissionToUserResponse::create(
                [],
                $success
            );

        } catch (\Exception $exception) {

            return GrantPermissionToUserResponse::create(
                [], false, $exception->getMessage()
            );
        }
    }
}