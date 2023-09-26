<?php

namespace Core\Application\User\Update\UserDelete;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\Service\UserDeleteDomainService;

class UserDeleteService implements ApplicationServiceInterface {

    private UserDeleteDomainService $userUpdateDomainService;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userUpdateDomainService = new UserDeleteDomainService(
            $userRepository
        );
    }

    /** @var UserDeleteRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {

            $success = $this->userUpdateDomainService->deleteUser(
                $request->getUserUniqueId()
            );

            return UserDeleteResponse::create(
                [],
                $success
            );

        } catch (\Exception $exception) {
            return UserDeleteResponse::create([], false, $exception->getMessage());
        }
    }
}