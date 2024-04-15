<?php

namespace Core\Application\User\PasswordReset\Update;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\User\Exception\UserNotFoundException;
use Core\Domain\User\Infrastructure\UserPasswordResetRequestRepositoryInterface;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\Service\UserByPasswordResetTokenDomainService;
use Core\Domain\User\Service\UserPasswordResetValidationDomainService;
use Core\Domain\User\Service\UserUpdateDomainService;

class UserPasswordResetUpdateService implements ApplicationServiceInterface {

    private UserUpdateDomainService $userUpdateDomainService;

    private UserByPasswordResetTokenDomainService $userByPasswordResetTokenDomainService;
    private UserPasswordResetValidationDomainService $userPasswordResetValidationDomainService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository
    )
    {
        $this->userUpdateDomainService = new UserUpdateDomainService(
            $userRepository
        );

        $this->userByPasswordResetTokenDomainService = new UserByPasswordResetTokenDomainService(
            $userPasswordResetRequestRepository
        );

        $this->userPasswordResetValidationDomainService = new UserPasswordResetValidationDomainService(
            $userPasswordResetRequestRepository
        );
    }

    /** @var UserPasswordResetUpdateRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            $this->userPasswordResetValidationDomainService->validateUserPasswordResetRequest(
                $request->getResetPasswordToken(),
                $request->getIpAddress()
            );

            $user = $this->userByPasswordResetTokenDomainService->find(
                $request->getResetPasswordToken()
            );

            if (!$user) {
                throw new UserNotFoundException();
            }

            $userUniqueId = $user->getUniqueId();
            $newPassword = $request->getNewPassword();

            $success = $this->userUpdateDomainService->updateUser(
                $userUniqueId,
                null, null, null,
                $newPassword
            );

            return UserPasswordResetUpdateResponse::create(
                [],
                $success
            );

        } catch (\Exception $exception) {
            return UserPasswordResetUpdateResponse::create([], false, $exception->getMessage());
        }
    }
}