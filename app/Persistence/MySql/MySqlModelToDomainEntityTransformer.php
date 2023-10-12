<?php

namespace App\Persistence\MySql;

use App\Models\ApplicationPermissionsModel;
use App\Models\ApplicationsModel;
use App\Models\ApplicationUsersModel;
use App\Models\Base\BaseModel;
use App\Models\UserApplicationPermissionsModel;
use App\Models\UsersModel;
use Core\Domain\Application\Application;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\ApplicationUser\ApplicationUser;
use Core\Domain\User\User;
use Core\Domain\UserPermission\UserPermission;

final class MySqlModelToDomainEntityTransformer {

    private static array $translations = [
        UsersModel::class => 'fromUsersModel',
        ApplicationsModel::class => 'fromApplicationsModel',
        ApplicationUsersModel::class => 'fromApplicationUsersModel',
        ApplicationPermissionsModel::class => 'fromApplicationPermissionsModel',
        UserApplicationPermissionsModel::class => 'fromUserApplicationPermissionsModel'
    ];

    /**
     * @throws \Exception
     */
    public static function execute(string $class, BaseModel $model)
    {
        $method = self::$translations[$class] ?? null;
        if (!$method) {
            throw new \Exception('Unregistered model transformer');
        }

        return self::$method($model);
    }

    private static function fromUsersModel(UsersModel $userModel): User
    {
        $user = User::create(
            $userModel->getId(),
            $userModel->getUniqueId(),
            $userModel->getUsername(),
            $userModel->getFullName(),
            $userModel->getEmail(),
            $userModel->getPassword()
        );

        if ($userModel->getDeletedAt() !== null) {
            $user->setIsDeleted(true);
        }

        return $user;
    }

    private static function fromApplicationsModel(ApplicationsModel $applicationModel): Application
    {
        $application = Application::create(
            $applicationModel->getId(),
            $applicationModel->getUniqueId(),
            $applicationModel->getAppName(),
            $applicationModel->getUrl(),
            $applicationModel->getCallbackUrl(),
            $applicationModel->getApiKey()
        );

        if ($applicationModel->getDeletedAt() !== null) {
            $application->setIsDeleted(true);
        }

        return $application;
    }

    private static function fromApplicationUsersModel(ApplicationUsersModel $applicationUserModel): ApplicationUser
    {
        $applicationUser = ApplicationUser::create(
            $applicationUserModel->getId(),
            $applicationUserModel->getUniqueId(),
            $applicationUserModel->getApplicationId(),
            $applicationUserModel->getUserId()
        );

        if ($applicationUserModel->getDeletedAt() !== null) {
            $applicationUser->setIsDeleted(true);
        }

        return $applicationUser;
    }

    private static function fromApplicationPermissionsModel(ApplicationPermissionsModel $applicationPermissionsModel): ApplicationPermission
    {
        $applicationPermission = ApplicationPermission::create(
            $applicationPermissionsModel->getId(),
            $applicationPermissionsModel->getUniqueId(),
            self::fromApplicationsModel(
                (new ApplicationsModel())->getOneById(
                    $applicationPermissionsModel->getApplicationId()
                )
            ),
            $applicationPermissionsModel->getPermissionName(),
            $applicationPermissionsModel->getPermissionDescription(),
            $applicationPermissionsModel->getIsActive()
        );

        if ($applicationPermissionsModel->getDeletedAt() !== null) {
            $applicationPermission->setIsDeleted(true);
        }

        return $applicationPermission;
    }

    private static function fromUserApplicationPermissionsModel(UserApplicationPermissionsModel $userApplicationPermissionsModel): UserPermission
    {
        $userPermission = UserPermission::create(
            $userApplicationPermissionsModel->getId(),
            $userApplicationPermissionsModel->getUniqueId(),
            self::fromUsersModel(
                (new UsersModel())->getOneById(
                    $userApplicationPermissionsModel->getUserId()
                )
            ),
            self::fromApplicationPermissionsModel(
                (new ApplicationPermissionsModel())->getOneById(
                    $userApplicationPermissionsModel->getApplicationPermissionId()
                )
            ),
            $userApplicationPermissionsModel->getIsGranted()
        );

        if ($userApplicationPermissionsModel->getDeletedAt() !== null) {
            $userPermission->setIsDeleted(true);
        }

        return $userPermission;
    }
}