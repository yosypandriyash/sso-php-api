<?php

namespace App\Persistence\MySql;

use App\Models\ApplicationsModel;
use App\Models\ApplicationUsersModel;
use App\Models\Base\BaseModel;
use App\Models\UsersModel;
use Core\Domain\Application\Application;
use Core\Domain\ApplicationUser\ApplicationUser;
use Core\Domain\User\User;

final class MySqlModelToDomainEntityTransformer
{
    private static array $translations = [
        UsersModel::class => 'fromUsersModel',
        ApplicationsModel::class => 'fromApplicationsModel',
        ApplicationUsersModel::class => 'fromApplicationUsersModel'
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
        return User::create(
            $userModel->getId(),
            $userModel->getUniqueId(),
            $userModel->getUsername(),
            $userModel->getFullName(),
            $userModel->getEmail(),
            $userModel->getPassword()
        );
    }

    private static function fromApplicationsModel(ApplicationsModel $applicationModel): Application
    {
        return Application::create(
            $applicationModel->getId(),
            $applicationModel->getUniqueId(),
            $applicationModel->getAppName(),
            $applicationModel->getUrl(),
            $applicationModel->getCallbackUrl(),
            $applicationModel->getApiKey()
        );
    }

    private static function fromApplicationUsersModel(ApplicationUsersModel $applicationUserModel): ApplicationUser
    {
        return ApplicationUser::create(
            $applicationUserModel->getId(),
            $applicationUserModel->getUniqueId(),
            $applicationUserModel->getApplicationId(),
            $applicationUserModel->getUserId()
        );
    }
}