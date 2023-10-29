<?php

namespace Core\Application\User\Create;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationValidationDomainService;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Core\Domain\Helpers\StringHelperInterface;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\Service\UserRegistrationDomainService;

class UserRegistrationService implements ApplicationServiceInterface {

    private UserRegistrationDomainService $userRegistrationDomainService;
    private ApplicationValidationDomainService $applicationValidationDomainService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ApplicationRepositoryInterface $applicationRepository,
        ApplicationUserRepositoryInterface $applicationUserRepository,
        StringHelperInterface $stringHelper
    )
    {
        $this->userRegistrationDomainService = new UserRegistrationDomainService(
            $userRepository,
            $applicationRepository,
            $applicationUserRepository,
            $stringHelper
        );

        $this->applicationValidationDomainService = new ApplicationValidationDomainService(
            $applicationRepository
        );
    }

    /** @var UserRegistrationRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            // Validate API-KEY for requested application
            $this->applicationValidationDomainService->validateApplicationRequest(
                $request->getAppUniqueId(),
                $request->getApiKey()
            );

            // Register User
            $user = $this->userRegistrationDomainService->registerUser(
                $request->getAppUniqueId(),
                $request->getUsername(),
                $request->getFullName(),
                $request->getEmail(),
                $request->getPassword()
            );

            return UserRegistrationResponse::create(
                $user->toArray(),
                true
            );

        } catch (\Exception $exception) {
            return UserRegistrationResponse::create([], false, $exception->getMessage());
        }
    }
}