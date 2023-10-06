<?php

namespace App\Persistence\MySql\ApplicationPermission;

use App\Models\ApplicationPermissionsModel;
use App\Persistence\Exception\CouldNotSaveException;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Exception;

class MySqlApplicationPermissionRepository extends ApplicationPermissionsModel implements ApplicationPermissionRepositoryInterface
{
    public function saveEntity(ApplicationPermission $applicationPermission): ApplicationPermission
    {
        $applicationPermissionModel = new ApplicationPermissionsModel();
        $applicationPermissionModel->setUniqueId($applicationPermission->getUniqueId());
        $applicationPermissionModel->setApplicationId($applicationPermission->getApplication()->getId()->getValue());
        $applicationPermissionModel->setPermissionName($applicationPermission->getPermissionName());
        $applicationPermissionModel->setPermissionDescription($applicationPermission->getPermissionDescription());
        $applicationPermissionModel->setIsActive($applicationPermission->isActive());


        try {
            if (!$applicationPermissionModel->save()) {
                throw new Exception();
            }

            $applicationPermission->setId($applicationPermissionModel->getLastInsertionId());

        } catch (Exception $exception) {
            throw new CouldNotSaveException();
        }

        return $applicationPermission;
    }

    public function getCountMatchesByApplicationIdAndPermissionName(string $applicationId, string $permissionName): int
    {
        return parent::getCountMatchesByApplicationIdAndPermissionName($applicationId, $permissionName);
    }
}