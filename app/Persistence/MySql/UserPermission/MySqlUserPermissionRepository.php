<?php

namespace App\Persistence\MySql\UserPermission;

use App\Models\UserApplicationPermissionsModel;
use App\Persistence\Exception\CouldNotSaveException;
use App\Persistence\MySql\MySqlDefinitions;
use App\Persistence\MySql\MySqlModelToDomainEntityTransformer;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\User\User;
use Core\Domain\UserPermission\Infrastructure\UserPermissionRepositoryInterface;
use Core\Domain\UserPermission\UserPermission;

class MySqlUserPermissionRepository extends UserApplicationPermissionsModel implements UserPermissionRepositoryInterface
{
    public function findByUserAndPermission(User $user, ApplicationPermission $applicationPermission): ?UserPermission
    {
        $userId = $user->getId()->getValue();
        $applicationPermissionId = $applicationPermission->getId()->getValue();

        $userPermission = $this->getOneByUserIdApplicationPermissionId($userId, $applicationPermissionId) ?? null;

        return $userPermission !== null ? MySqlModelToDomainEntityTransformer::execute(
            UserApplicationPermissionsModel::class, $userPermission
        ): null;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function saveEntity(UserPermission $userPermission): UserPermission
    {
        if ($userPermission->getId() === null) {
            $userPermissionModel = new UserApplicationPermissionsModel();
            $userPermissionModel->setUniqueId($userPermission->getUniqueId());
        } else {
            $userPermissionModel = $this->getOneById($userPermission->getId()->getValue());
        }

        $userPermissionModel->setUserId($userPermission->getUser()->getId()->getValue());
        $userPermissionModel->setApplicationPermissionId($userPermission->getApplicationPermission()->getId()->getValue());
        $userPermissionModel->setIsGranted($userPermission->isGranted());

        if ($userPermission->getUpdatedAt() !== null) {
            $userPermissionModel->setUpdatedAt(
                $userPermission->getUpdatedAt()->format(MySqlDefinitions::DATE_FORMAT)
            );
        }

        if ($userPermission->isDeleted() === true) {
            $userPermissionModel->setDeletedAt(
                $userPermission->getDeletedAt()->format(MySqlDefinitions::DATE_FORMAT)
            );
        }

        try {

            if (!$userPermissionModel->save()) {
                throw new \Exception();
            }

            if ($userPermission->getId() === null) {
                $userPermission->setId($userPermissionModel->getLastInsertionId());
            }

        } catch (\Exception $exception) {
            throw new CouldNotSaveException();
        }

        return $userPermission;
    }
}