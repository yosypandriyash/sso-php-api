<?php

namespace Core\Application\ApplicationPermission\Create\ApplicationPermissionRegistration;

use App\Helpers\StringHelperInterface;
use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationValidationDomainService;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Core\Domain\ApplicationPermission\Service\ApplicationPermissionRegistrationDomainService;

class ApplicationPermissionRegistrationService implements ApplicationServiceInterface {

    private ApplicationPermissionRegistrationDomainService $applicationPermissionRegistrationDomainService;
    private ApplicationValidationDomainService $applicationValidationDomainService;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        ApplicationPermissionRepositoryInterface $applicationPermissionRepository,
        StringHelperInterface $stringHelper
    )
    {
        $this->applicationValidationDomainService = new ApplicationValidationDomainService(
            $applicationRepository
        );

        $this->applicationPermissionRegistrationDomainService = new ApplicationPermissionRegistrationDomainService(
            $applicationPermissionRepository,
            $applicationRepository,
            $stringHelper
        );
    }

    /** @var ApplicationPermissionRegistrationRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            // Validate API-KEY for requested application
            $this->applicationValidationDomainService->validateApplicationRequest(
                $request->getAppUniqueId(),
                $request->getApiKey()
            );

            // Register Application permission
            $user = $this->applicationPermissionRegistrationDomainService->registerApplicationPermission(
                $request->getAppUniqueId(),
                $request->getPermissionName(),
                $request->getPermissionDescription(),
                $request->isActive()
            );

            return ApplicationPermissionRegistrationResponse::create(
                $user->toArray(),
                true
            );

        } catch (\Exception $exception) {
            return ApplicationPermissionRegistrationResponse::create([], false, $exception->getMessage());
        }
    }
}