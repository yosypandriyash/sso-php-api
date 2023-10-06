<?php

namespace Core\Domain\ApplicationPermission\Infrastructure;


use Core\Domain\ApplicationPermission\ApplicationPermission;

interface ApplicationPermissionRepositoryInterface {

    public function saveEntity(ApplicationPermission $applicationPermission): ApplicationPermission;

    public function getCountMatchesByApplicationIdAndPermissionName(
        string $applicationId,
        string $permissionName
    ): int;
}