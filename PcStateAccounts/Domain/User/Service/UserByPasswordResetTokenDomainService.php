<?php

namespace Core\Domain\User\Service;

use Core\Domain\BaseDomainService;
use Core\Domain\User\Exception\InvalidUserPasswordResetTokenException;
use Core\Domain\User\Infrastructure\UserPasswordResetRequestRepositoryInterface;
use Core\Domain\User\User;

class UserByPasswordResetTokenDomainService extends BaseDomainService {

    private UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository;

    public function __construct(
        UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository
    )
    {
        $this->userPasswordResetRequestRepository = $userPasswordResetRequestRepository;
    }

    public function find(
        string $resetUserPasswordToken
    ): ?User
    {
        $request = $this->userPasswordResetRequestRepository->getOneByUniqueId($resetUserPasswordToken);

        if (!$request) {
            throw new InvalidUserPasswordResetTokenException();
        }

        return $request->getUser();

        // todo/update: Log user-update request
    }
}