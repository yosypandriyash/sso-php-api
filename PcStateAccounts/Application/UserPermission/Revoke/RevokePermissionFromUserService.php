<?php

namespace Core\Application\UserPermission\Revoke;

use App\Helpers\StringHelperInterface;
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
use Core\Domain\UserPermission\Service\RevokePermissionFromUserDomainService;

class RevokePermissionFromUserService implements ApplicationServiceInterface {

    private ApplicationValidationDomainService $applicationValidationDomainService;
    private RevokePermissionFromUserDomainService $revokePermissionFromUserDomainService;
    private ApplicationUserValidationDomainService $applicationUserValidationDomainService;
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

        $this->revokePermissionFromUserDomainService = new RevokePermissionFromUserDomainService(
            $userRepository,
            $userPermissionRepository,
            $applicationPermissionRepository
        );

        $this->applicationUserValidationDomainService = new ApplicationUserValidationDomainService(
            $applicationUserRepository
        );

    }

    /** @var RevokePermissionFromUserRequest $request */
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

            $success = $this->revokePermissionFromUserDomainService->revokePermissionFromUser(
                $request->getUserUniqueId(),
                $request->getPermissionUniqueId()
            );

            return RevokePermissionFromUserResponse::create(
                [],
                $success
            );

        } catch (\Exception $exception) {

            return RevokePermissionFromUserResponse::create(
                [], false, $exception->getMessage()
            );
        }
    }
}