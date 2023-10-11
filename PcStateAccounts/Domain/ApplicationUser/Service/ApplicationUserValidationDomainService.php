<?php

namespace Core\Domain\ApplicationUser\Service;

use Core\Domain\ApplicationUser\Exception\UserNotBelongToApplicationException;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Core\Domain\BaseDomainService;

class ApplicationUserValidationDomainService extends BaseDomainService {

    private ApplicationUserRepositoryInterface $applicationUserRepository;

    public function __construct(
        ApplicationUserRepositoryInterface $applicationUserRepository
    )
    {
        $this->applicationUserRepository = $applicationUserRepository;
    }

    /**
     * @throws UserNotBelongToApplicationException
     */
    public function validateUserBelongsToApplication(
        string $applicationUniqueId,
        string $userUniqueId
    ): void
    {
        $matchesCount = $this->applicationUserRepository->getApplicationUserCount(
            $applicationUniqueId,
            $userUniqueId
        );

        if ($matchesCount === 0) {
            throw new UserNotBelongToApplicationException();
        }
    }
}