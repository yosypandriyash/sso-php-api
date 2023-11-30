<?php

namespace Core\Application\User\Reset;

use Core\Application\ApplicationRequestInterface;
use Core\Application\ApplicationResponseInterface;
use Core\Application\ApplicationServiceInterface;
use Core\Application\Notification\Infrastructure\NotificationSenderInterface;
use Core\Application\Notification\Template\ResetPasswordRequestNotification;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;
use Core\Domain\Application\Service\ApplicationValidationDomainService;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Core\Domain\Helpers\StringHelperInterface;
use Core\Domain\User\Infrastructure\UserPasswordResetRequestRepositoryInterface;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\Service\UserPasswordResetRequestDomainService;

class UserPasswordResetRequestService implements ApplicationServiceInterface {
    private NotificationSenderInterface $notificationSender;
    private ApplicationValidationDomainService $applicationValidationDomainService;
    private UserPasswordResetRequestDomainService $userPasswordResetRequestDomainService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository,
        ApplicationRepositoryInterface $applicationRepository,
        NotificationSenderInterface $notificationSender,
        StringHelperInterface $stringHelper
    )
    {
        $this->notificationSender = $notificationSender;

        $this->applicationValidationDomainService = new ApplicationValidationDomainService(
            $applicationRepository
        );

        $this->userPasswordResetRequestDomainService = new UserPasswordResetRequestDomainService(
            $stringHelper,
            $userRepository,
            $userPasswordResetRequestRepository
        );
    }

    /** @var UserPasswordResetRequestRequest $request */
    public function execute(ApplicationRequestInterface $request): ApplicationResponseInterface
    {
        try {
            // Validate API-KEY for requested application
            $this->applicationValidationDomainService->validateApplicationRequest(
                $request->getAppUniqueId(),
                $request->getApiKey()
            );

            $passwordRequest = $this->userPasswordResetRequestDomainService->processUserPasswordResetRequest(
                $request->getEmail(),
                $request->getIpAddress()
            );

            // Send user notification
            $notification = ResetPasswordRequestNotification::create();
            $notification->setTo($passwordRequest->getUser()->getEmail());

            $passwordResetValidationUrl = $this->parseResetPasswordUrl(
                $request->getResetPasswordUrlPattern(),
                $request->getPasswordResetPlaceholder(),
                $passwordRequest->getUniqueId()
            );

            $notification->setPlaceholders([
                '<:passwordResetUrl:>' => $passwordResetValidationUrl
            ]);

            $this->notificationSender->sendNotification(
                $notification
            );

            return UserPasswordResetRequestResponse::create(
                [],
                true
            );

        } catch (\Exception $exception) {
            return UserPasswordResetRequestResponse::create([], false, $exception->getMessage());
        }
    }

    private function parseResetPasswordUrl($baseUrl, $tokenPlaceholder, $tokenValue): string
    {
        return str_replace($tokenPlaceholder, $tokenValue, $baseUrl);
    }
}