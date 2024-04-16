<?php

namespace App\Persistence\MySql\ApplicationPermission;

use App\Models\ApplicationPermissionsModel;
use App\Persistence\Exception\CouldNotSaveException;
use App\Persistence\MySql\MySqlDefinitions;
use App\Persistence\MySql\MySqlModelToDomainEntityTransformer;
use Core\Domain\Application\Application;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\ApplicationPermission\ApplicationPermissionsList;
use Core\Domain\ApplicationPermission\Infrastructure\ApplicationPermissionRepositoryInterface;
use Exception;

class MySqlApplicationPermissionRepository extends ApplicationPermissionsModel implements ApplicationPermissionRepositoryInterface
{
    /**
     * @throws CouldNotSaveException
     */
    public function saveEntity(ApplicationPermission $applicationPermission): ApplicationPermission
    {
        $applicationPermissionModel = new ApplicationPermissionsModel();
        $applicationPermissionModel->setId($applicationPermission->getId()->getValue());
        $applicationPermissionModel->setUniqueId($applicationPermission->getUniqueId());
        $applicationPermissionModel->setApplicationId($applicationPermission->getApplication()->getId()->getValue());
        $applicationPermissionModel->setPermissionName($applicationPermission->getPermissionName());
        $applicationPermissionModel->setPermissionDescription($applicationPermission->getPermissionDescription());
        $applicationPermissionModel->setIsActive($applicationPermission->isActive());

        if ($applicationPermission->getUpdatedAt() !== null) {
            $applicationPermissionModel->setUpdatedAt($applicationPermission->getUpdatedAt()->format(MySqlDefinitions::DATE_FORMAT));
        }

        if ($applicationPermission->isDeleted()) {
            $applicationPermissionModel->setDeletedAt($applicationPermission->getDeletedAt()->format(MySqlDefinitions::DATE_FORMAT));
        }

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

    public function getCountMatchesByApplicationIdAndPermissionName(int $applicationId, string $permissionName): int
    {
        return parent::getCountMatchesByApplicationIdAndPermissionName($applicationId, $permissionName);
    }

    /**
     * @throws Exception
     */
    public function getOneByUniqueId(string $permissionUniqueId): ?ApplicationPermission
    {
        $applicationPermissionModel = $this->getApplicationPermissionByUniqueId($permissionUniqueId);
        return $applicationPermissionModel !== null ? MySqlModelToDomainEntityTransformer::execute(
            ApplicationPermissionsModel::class, $applicationPermissionModel
        ): null;
    }

    public function getAllApplicationPermissions(
        Application $application
    ): ApplicationPermissionsList
    {
        $applicationId = $application->getId()->getValue();
        $applicationPermissionsList = ApplicationPermissionsList::create();

        $applicationPermissions = $this->getAll([
            'applicationId' => $applicationId
        ]);

        /** @var ApplicationPermissionsModel $applicationPermissionModel */
        foreach ($applicationPermissions as $applicationPermissionModel) {

            /** @var ApplicationPermission $applicationPermission */
            $applicationPermission = MySqlModelToDomainEntityTransformer::execute(
                ApplicationPermissionsModel::class, $applicationPermissionModel
            );

            $applicationPermissionsList->add($applicationPermission);
        }

        return $applicationPermissionsList;
    }
}