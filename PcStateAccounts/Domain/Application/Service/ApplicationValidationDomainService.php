<?php

namespace Core\Domain\Application\Service;

use Core\Domain\Application\Exception\InvalidApplicationRequestTokenException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\BaseDomainService;

class ApplicationValidationDomainService extends BaseDomainService {

    private ApplicationRepositoryInterface $applicationRepository;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository
    )
    {
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * @param string $applicationUniqueId
     * @param string $applicationApiKey
     * @return void
     * @throws InvalidApplicationRequestTokenException
     */
    public function validateApplicationRequest(
        string $applicationUniqueId,
        string $applicationApiKey
    ): void
    {
        $validApplicationRequest = $this->applicationRepository->validateApplicationRequest(
            $applicationUniqueId,
            $applicationApiKey
        );

        if (!$validApplicationRequest) {
            throw new InvalidApplicationRequestTokenException();
        }
    }
}