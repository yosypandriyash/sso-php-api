<?php

namespace App\Persistence\MySql\User;

use App\Models\UserPasswordResetRequestsModel;
use App\Persistence\Exception\CouldNotSaveException;
use App\Persistence\MySql\MySqlDefinitions;
use App\Persistence\MySql\MySqlModelToDomainEntityTransformer;
use Core\Domain\User\Infrastructure\UserPasswordResetRequestRepositoryInterface;
use Core\Domain\User\User;
use Core\Domain\User\UserPasswordResetRequest;
use Exception;

class MySqlUserPasswordResetRequestRepository extends UserPasswordResetRequestsModel implements UserPasswordResetRequestRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function getOneByUniqueId(string $uniqueId): ?UserPasswordResetRequest
    {
        $userPasswordResetRequest = $this->getByUniqueId($uniqueId);
        return $userPasswordResetRequest !== null ? MySqlModelToDomainEntityTransformer::execute(
            UserPasswordResetRequestsModel::class, $userPasswordResetRequest
        ): null;
    }

    /**
     * @throws CouldNotSaveException
     * @throws Exception
     */
    public function saveEntity(UserPasswordResetRequest $userPasswordResetRequest): UserPasswordResetRequest
    {
        if ($userPasswordResetRequest->getId() === null) {
            $userPasswordResetRequestsModel = new UserPasswordResetRequestsModel();
            $userPasswordResetRequestsModel->setUniqueId($userPasswordResetRequest->getUniqueId());
            $userPasswordResetRequestsModel->setUserId($userPasswordResetRequest->getUser()->getId()->getValue());
        } else {
            // Update
            $userPasswordResetRequestsModel = $this->getOneByUniqueId($userPasswordResetRequest->getUniqueId());
        }

        // setters
        $userPasswordResetRequestsModel->setOriginIp($userPasswordResetRequest->getOriginIpAddress());
        $userPasswordResetRequestsModel->setIsActive($userPasswordResetRequest->isActive());
        $userPasswordResetRequestsModel->setExpirationDate($userPasswordResetRequest->getExpirationDate()->format(MySqlDefinitions::DATE_FORMAT));

        if ($userPasswordResetRequest->getUpdatedAt() !== null) {
            $userPasswordResetRequestsModel->setUpdatedAt($userPasswordResetRequest->getUpdatedAt()->format(MySqlDefinitions::DATE_FORMAT));
        }

        if ($userPasswordResetRequest->isDeleted()) {
            $userPasswordResetRequestsModel->setDeletedAt($userPasswordResetRequest->getDeletedAt()->format(MySqlDefinitions::DATE_FORMAT));
        }

        try {
            if (!$userPasswordResetRequestsModel->save()) {
                throw new Exception();
            }

            if ($userPasswordResetRequest->getId() === null) {
                $userPasswordResetRequest->setId($userPasswordResetRequestsModel->getLastInsertionId());
            }

        } catch (Exception $exception) {
            throw new CouldNotSaveException();
        }

        return $userPasswordResetRequest;
    }

    public function getOneActiveByUser(User $user): ?UserPasswordResetRequest
    {
        $userPasswordResetRequest = $this->getOneActiveByUserId($user->getId()->getValue());
        return $userPasswordResetRequest !== null ? MySqlModelToDomainEntityTransformer::execute(
            UserPasswordResetRequestsModel::class, $userPasswordResetRequest
        ): null;
    }
}