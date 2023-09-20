<?php

namespace Core\Domain\User\Service;

use App\Helpers\StringHelperInterface;
use Core\Domain\Application\Exception\ApplicationNotFoundException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\ApplicationUser\ApplicationUser;
use Core\Domain\ApplicationUser\Exception\ApplicationUserDuplicatedException;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Core\Domain\BaseDomainService;
use Core\Domain\User\Exception\DuplicatedUserException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\User;

class UserRegistrationDomainService extends BaseDomainService {

    private UserRepositoryInterface $userRepository;
    private ApplicationRepositoryInterface $applicationRepository;
    private ApplicationUserRepositoryInterface $applicationUserRepository;
    private StringHelperInterface $stringHelper;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ApplicationRepositoryInterface $applicationRepository,
        ApplicationUserRepositoryInterface $applicationUserRepository,
        StringHelperInterface $stringHelper
    )
    {
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
        $this->applicationUserRepository = $applicationUserRepository;
        $this->stringHelper = $stringHelper;
    }

    /**
     * @param string $applicationUniqueId
     * @param string $username
     * @param string $fullName
     * @param string $email
     * @param string $password
     * @return User|null
     * @throws ApplicationNotFoundException
     * @throws ApplicationUserDuplicatedException
     * @throws DuplicatedUserException
     */
    public function registerUser(
        string $applicationUniqueId,
        string $username,
        string $fullName,
        string $email,
        string $password
    ): ?User
    {
        $application = $this->applicationRepository->getApplicationByUniqueId($applicationUniqueId);

        if (!$application) {
            throw new ApplicationNotFoundException();
        }

        // Prevent duplicated user registration
        $match = $this->userRepository->getOneByUserNameAndEmail($username, $email);

        if ($match !== null) {
            throw new DuplicatedUserException();
        }

        $matches = $this->applicationUserRepository->getApplicationUsersCount($applicationUniqueId, $email);
        if ($matches > ApplicationUser::MAXIMUM_ALLOWED_DUPLICATED_APPLICATION_USERS) {
            throw new ApplicationUserDuplicatedException();
        }

        $user = User::create(
            null,
            $this->stringHelper->getRandomString(User::UNIQUE_ID_LENGTH),
            $username,
            $fullName,
            $email,
            $password
        );

        $user = $this->userRepository->saveEntity($user);

        $this->applicationUserRepository->saveEntity(
            ApplicationUser::create(
                null,
                $this->stringHelper->getRandomString(ApplicationUser::UNIQUE_ID_LENGTH),
                $application,
                $user
            )
        );

        return $user;
    }
}