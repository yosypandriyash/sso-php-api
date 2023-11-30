<?php

namespace Core\Domain\User\Service;

use Core\Domain\BaseDomainService;
use Core\Domain\User\UserPasswordResetRequest;
use Core\Domain\Helpers\StringHelperInterface;
use Core\Domain\User\Exception\UserNotFoundException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\Exception\CouldNotSaveUserPasswordResetRequestException;
use Core\Domain\User\Infrastructure\UserPasswordResetRequestRepositoryInterface;

class UserPasswordResetRequestDomainService extends BaseDomainService {

    private StringHelperInterface $stringHelper;
    private UserRepositoryInterface $userRepository;
    private UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository;

    public function __construct(
        StringHelperInterface $stringHelper,
        UserRepositoryInterface $userRepository,
        UserPasswordResetRequestRepositoryInterface $userPasswordResetRequestRepository
    )
    {
        $this->stringHelper = $stringHelper;
        $this->userRepository = $userRepository;
        $this->userPasswordResetRequestRepository = $userPasswordResetRequestRepository;
    }

    /**
     * @throws UserNotFoundException
     * @throws CouldNotSaveUserPasswordResetRequestException
     */
    public function processUserPasswordResetRequest(
        string $userEmail,
        string $originIpAddress
    ): UserPasswordResetRequest
    {
        $user = $this->userRepository->getOneByEmail($userEmail);

        if (!$user) {
            throw new UserNotFoundException();
        }

        // check if user (by email) have not any other active requests
        $activeRequest = $this->userPasswordResetRequestRepository->getOneActiveByUser($user);

        if ($activeRequest !== null) {
            return $activeRequest;
        }

        $uniqueId = $this->stringHelper->getRandomString(UserPasswordResetRequest::UNIQUE_ID_LENGTH);
        $isActiveRequest = UserPasswordResetRequest::DEFAULT_REQUEST_ACTIVE_STATUS;

        $userPasswordResetRequest = UserPasswordResetRequest::create(
            null,
            $user,
            $uniqueId,
            $originIpAddress,
            $isActiveRequest,
            $this->calculateRequestExpirationDate(),
        );

        try {

            return $this->userPasswordResetRequestRepository->saveEntity($userPasswordResetRequest);

        } catch (\Exception $exception) {

            throw new CouldNotSaveUserPasswordResetRequestException();
        }

        // todo/update: Log this request

    }

    private function calculateRequestExpirationDate(): \DateTime
    {
        $defaultExpirationInterval = UserPasswordResetRequest::REQUEST_EXPIRATION_HOURS;
        return (new \DateTime())->modify("+$defaultExpirationInterval hours");
    }
}