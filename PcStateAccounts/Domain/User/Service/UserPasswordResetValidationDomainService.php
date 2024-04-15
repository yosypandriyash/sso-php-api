<?php

namespace Core\Domain\User\Service;

use Core\Domain\BaseDomainService;
use Core\Domain\User\Exception\ExpiredUserPasswordRequestException;
use Core\Domain\User\Exception\InactiveUserException;
use Core\Domain\User\Exception\InactiveUserPasswordRequestException;
use Core\Domain\User\Exception\InvalidUserPasswordResetTokenException;
use Core\Domain\User\Exception\MismatchIpAddressUserPasswordRequestException;
use Core\Domain\User\Infrastructure\UserPasswordResetRequestRepositoryInterface;

class UserPasswordResetValidationDomainService extends BaseDomainService {

    private UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository;

    public function __construct(
        UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository
    )
    {
        $this->userPasswordResetRequestRepository = $userPasswordResetRequestRepository;
    }

    /**
     * @throws ExpiredUserPasswordRequestException
     * @throws InactiveUserException
     * @throws InactiveUserPasswordRequestException
     * @throws InvalidUserPasswordResetTokenException
     * @throws MismatchIpAddressUserPasswordRequestException
     */
    public function validateUserPasswordResetRequest(
        string $passwordResetRequestToken,
        string $ipAddress
    ): void
    {

        $passwordResetRequest = $this->userPasswordResetRequestRepository->getOneByUniqueId($passwordResetRequestToken);

        if (!$passwordResetRequest) {
            throw new InvalidUserPasswordResetTokenException();
        }

        $userActive = $passwordResetRequest->getUser()->isDeleted() === false;

        if (!$userActive) {
            throw new InactiveUserException();
        }

        if (!$passwordResetRequest->isActive()) {
            throw new InactiveUserPasswordRequestException();
        }

        if ($passwordResetRequest->getExpirationDate() < new \DateTime()) {
            throw new ExpiredUserPasswordRequestException();
        }

        if ($passwordResetRequest->getOriginIpAddress() !== $ipAddress) {
            throw new MismatchIpAddressUserPasswordRequestException();
        }

        // todo/update: Log this request

    }

}