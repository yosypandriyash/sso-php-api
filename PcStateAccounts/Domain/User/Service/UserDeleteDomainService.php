<?php

namespace Core\Domain\User\Service;

use Core\Domain\BaseDomainService;
use Core\Domain\User\Exception\CouldNotSaveUserException;
use Core\Domain\User\Exception\UserNotFoundException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;

class UserDeleteDomainService extends BaseDomainService {

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
    public function deleteUser(
        string $userUniqueId
    ): bool
    {
        $user = $this->userRepository->getOneByUniqueId($userUniqueId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        try {

            $user->setIsDeleted(true);
            $this->userRepository->saveEntity($user);

        } catch (\Exception $exception) {
            throw new CouldNotSaveUserException();
        }

        // todo/update: Log user-update request

        return true;
    }
}