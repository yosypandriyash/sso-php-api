<?php

namespace Core\Domain\ApplicationPermission\Infrastructure;


use Core\Domain\Application\Application;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\ApplicationPermission\ApplicationPermissionsList;

interface ApplicationPermissionRepositoryInterface {

    public function getOneByUniqueId(string $permissionUniqueId): ?ApplicationPermission;

    public function saveEntity(ApplicationPermission $applicationPermission): ApplicationPermission;

    public function getCountMatchesByApplicationIdAndPermissionName(
        int $applicationId,
        string $permissionName
    ): int;

    public function getAllApplicationPermissions(
        Application $application
    ): ApplicationPermissionsList;

}