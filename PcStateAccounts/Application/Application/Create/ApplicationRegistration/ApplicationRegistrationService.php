<?php

namespace Core\Application\Application\Create\ApplicationRegistration;

use App\Helpers\StringHelperInterface;
use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationRegistrationDomainService;

class ApplicationRegistrationService implements ApplicationServiceInterface {

    private ApplicationRegistrationDomainService $applicationRegistrationDomainService;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        StringHelperInterface $stringHelper
    )
    {
        $this->applicationRegistrationDomainService = new ApplicationRegistrationDomainService(
            $applicationRepository,
            $stringHelper
        );
    }

    public function execute(ApplicationRequestInterface $request): ApplicationRegistrationResponse
    {
        try {
            /** @var ApplicationRegistrationRequest $request */
            $application = $this->applicationRegistrationDomainService->registerApplication(
                $request->getName(),
                $request->getUrl(),
                $request->getCallbackUrl()
            );

            return ApplicationRegistrationResponse::create(
                $application->toArray(),
                true
            );

        } catch (\Exception $exception) {
            return ApplicationRegistrationResponse::create([], false, $exception->getMessage());
        }
    }
}