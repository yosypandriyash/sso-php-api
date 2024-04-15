<?php

namespace Core\Application\User\PasswordReset\Validation;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\User\Exception\InvalidUserPasswordResetTokenException;
use Core\Domain\User\Infrastructure\UserPasswordResetRequestRepositoryInterface;
use Core\Domain\User\Service\UserPasswordResetValidationDomainService;

class UserPasswordResetValidationService implements ApplicationServiceInterface {
    private UserPasswordResetValidationDomainService $userPasswordResetValidationDomainService;

    public function __construct(
        UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository
    )
    {
        $this->userPasswordResetValidationDomainService = new UserPasswordResetValidationDomainService(
            $userPasswordResetRequestRepository
        );
    }

    /** @var UserPasswordResetValidationRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            $this->userPasswordResetValidationDomainService->validateUserPasswordResetRequest(
                $request->getResetPasswordToken(),
                $request->getIpAddress()
            );

            return UserPasswordResetValidationResponse::create(
                [],
                true
            );

        } catch (\Exception $exception) {
            return UserPasswordResetValidationResponse::create([], false, $exception->getMessage());
        }
    }

}