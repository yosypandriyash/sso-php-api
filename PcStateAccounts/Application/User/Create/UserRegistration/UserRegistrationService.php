<?php

namespace Core\Application\User\Create\UserRegistration;

use App\Helpers\StringHelperInterface;
use Core\Application\Application\Create\ApplicationRegistration\ApplicationRegistrationResponse;
use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\Service\UserRegistrationDomainService;

class UserRegistrationService implements ApplicationServiceInterface {

    private UserRegistrationDomainService $userRegistrationDomainService;

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
    }

    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            /** @var UserRegistrationRequest $request */
            $user = $this->userRegistrationDomainService->registerUser(
                $request->getAppUniqueId(),
                $request->getUsername(),
                $request->getFullName(),
                $request->getEmail(),
                $request->getPassword()
            );

            return ApplicationRegistrationResponse::create(
                $user->toArray(),
                true
            );

        } catch (\Exception $exception) {
            return ApplicationRegistrationResponse::create([], false, $exception->getMessage());
        }
    }
}