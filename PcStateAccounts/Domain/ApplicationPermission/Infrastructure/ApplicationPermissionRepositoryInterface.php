<?php

namespace Core\Domain\ApplicationPermission\Infrastructure;


use Core\Domain\ApplicationPermission\ApplicationPermission;

interface ApplicationPermissionRepositoryInterface {

    public function getOneByUniqueId(string $permissionUniqueId): ?ApplicationPermission;

    public function saveEntity(ApplicationPermission $applicationPermission): ApplicationPermission;

    public function getCountMatchesByApplicationIdAndPermissionName(
        int $applicationId,
        string $permissionName
    ): int;

}