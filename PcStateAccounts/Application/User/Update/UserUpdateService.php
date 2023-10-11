<?php

namespace Core\Application\User\Update;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\Service\UserUpdateDomainService;

class UserUpdateService implements ApplicationServiceInterface {

    private UserUpdateDomainService $userUpdateDomainService;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userUpdateDomainService = new UserUpdateDomainService(
            $userRepository
        );
    }

    /** @var UserUpdateRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {

            $success = $this->userUpdateDomainService->updateUser(
                $request->getUserUniqueId(),
                $request->getUsername(),
                $request->getFullName(),
                $request->getEmail(),
                $request->getPassword()
            );

            return UserUpdateResponse::create(
                [],
                $success
            );

        } catch (\Exception $exception) {
            return UserUpdateResponse::create([], false, $exception->getMessage());
        }
    }
}