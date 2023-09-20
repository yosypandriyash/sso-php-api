<?php

namespace Core\Domain\Application\Service;

use App\Helpers\StringHelperInterface;
use Core\Domain\Application\Application;
use Core\Domain\Application\Exception\ApplicationSameNameExistsException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\BaseDomainService;

class ApplicationRegistrationDomainService extends BaseDomainService {

    private ApplicationRepositoryInterface $applicationRepository;
    private StringHelperInterface $stringHelper;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        StringHelperInterface $stringHelper
    )
    {
        $this->applicationRepository = $applicationRepository;
        $this->stringHelper = $stringHelper;
    }

    /**
     * @param string $applicationName
     * @param string $url
     * @param string $callbackUrl
     * @return Application|null
     * @throws ApplicationSameNameExistsException
     */
    public function registerApplication(
        string $applicationName,
        string $url,
        string $callbackUrl
    ): ?Application
    {
        $application = $this->applicationRepository->getApplicationByName(
            $applicationName
        );

        if ($application !== null) {
            throw new ApplicationSameNameExistsException();
        }

        $uniqueId = $this->stringHelper->getRandomString(Application::UNIQUE_ID_LENGTH);
        $apiKey = $this->stringHelper->getRandomString(Application::API_KEY_LENGTH);

        $application = Application::create(
            null,
            $uniqueId,
            $applicationName,
            $url,
            $callbackUrl,
            $apiKey
        );

        $this->applicationRepository->saveEntity($application);
        return $application;
    }
}