<?php

namespace Core\Domain\User\Service;

use Core\Domain\BaseDomainService;
use Core\Domain\User\Infrastructure\UserPasswordResetRequestRepositoryInterface;

class UserPasswordResetValidationDomainService extends BaseDomainService {

    private UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository;

    public function __construct(
        UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository
    )
    {
        $this->userPasswordResetRequestRepository = $userPasswordResetRequestRepository;
    }

    public function validateUserPasswordResetRequest(
        string $passwordResetRequestToken,
        string $ipAddress
    ): bool
    {
        try {
            $passwordResetRequest = $this->userPasswordResetRequestRepository->getOneByUniqueId($passwordResetRequestToken);

            if (!$passwordResetRequest) {
                return false;
            }

            $userActive = $passwordResetRequest->getUser()->isDeleted() === false;

            return
                $userActive === true &&
                $passwordResetRequest->isActive() === true &&
                $passwordResetRequest->getExpirationDate() >= new \DateTime() &&
                $passwordResetRequest->getOriginIpAddress() === $ipAddress;

        } catch (\Exception $exception) {

            return false;
        }

        // todo/update: Log this request

    }

}