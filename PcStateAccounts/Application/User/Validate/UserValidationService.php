<?php

namespace Core\Application\User\Validate;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationValidationDomainService;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\Service\UserValidationDomainService;

class UserValidationService implements ApplicationServiceInterface {

    private UserValidationDomainService $userValidationDomainService;
    private ApplicationValidationDomainService $applicationValidationDomainService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ApplicationRepositoryInterface $applicationRepository
    )
    {
        $this->userValidationDomainService = new UserValidationDomainService(
            $userRepository,
            $applicationRepository,
        );

        $this->applicationValidationDomainService = new ApplicationValidationDomainService(
            $applicationRepository
        );
    }

    /** @var UserValidationRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            // Validate API-KEY for requested application
            $this->applicationValidationDomainService->validateApplicationRequest(
                $request->getAppUniqueId(),
                $request->getApiKey()
            );

            // Validate User
            $this->userValidationDomainService->validateUser(
                $request->getAppUniqueId(),
                $request->getEmail(),
                $request->getPassword()
            );

            return UserValidationResponse::create(
                ['successValidated' => true],
                true
            );

        } catch (\Exception $exception) {
            return UserValidationResponse::create(
                ['successValidated' => true],
                false,
                $exception->getMessage()
            );
        }
    }
}