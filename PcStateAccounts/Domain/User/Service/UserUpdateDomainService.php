<?php

namespace Core\Domain\User\Service;

use Core\Domain\BaseDomainService;
use Core\Domain\User\Exception\CouldNotSaveUserException;
use Core\Domain\User\Exception\UserNotFoundException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;

class UserUpdateDomainService extends BaseDomainService {

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws CouldNotSaveUserException
     * @throws UserNotFoundException
     */
    public function updateUser(
        string $userUniqueId,
        ?string $username,
        ?string $fullName,
        ?string $email,
        ?string $password
    ): bool
    {
        $user = $this->userRepository->getOneByUniqueId($userUniqueId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        try {
            if ($username !== null) {
                $user->setUsername($username);
            }

            if ($fullName !== null) {
                $user->setFullName($fullName);
            }

            if ($email !== null) {
                $user->setEmail($email);
            }

            if ($password !== null) {
                $user->setPassword($password);
            }

            $this->userRepository->saveEntity($user);

        } catch (\Exception $exception) {
            throw new CouldNotSaveUserException();
        }

        // todo/update: Log user-update request

        return true;
    }
}