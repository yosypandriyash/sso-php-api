<?php

namespace Core\Domain\User\Service;

use Core\Domain\Application\Exception\ApplicationNotFoundException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\ApplicationUser\Exception\UserNotBelongToApplicationException;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Core\Domain\BaseDomainService;
use Core\Domain\User\Exception\InvalidUserCredentialsException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;

class UserValidationDomainService extends BaseDomainService {

    private UserRepositoryInterface $userRepository;
    private ApplicationRepositoryInterface $applicationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ApplicationRepositoryInterface $applicationRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * @throws ApplicationNotFoundException
     * @throws InvalidUserCredentialsException
     */
    public function validateUser(
        string $applicationUniqueId,
        string $email,
        string $password
    ): void
    {
        // Validate application uniqueId
        $application = $this->applicationRepository->getApplicationByUniqueId($applicationUniqueId);

        if (!$application) {
            throw new ApplicationNotFoundException();
        }

        // Prevent duplicated user registration
        $user = $this->userRepository->getOneByEmailAndPassword($email, $password);

        if (!$user) {
            throw new InvalidUserCredentialsException();
        }

        // todo/update: Log user-validation request
    }
}