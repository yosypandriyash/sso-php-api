<?php

namespace Core\Domain\UserPermission\Infrastructure;

use Core\Domain\Application\Application;
use Core\Domain\ApplicationPermission\ApplicationPermission;
use Core\Domain\User\User;
use Core\Domain\UserPermission\GrantedPermissionsList;
use Core\Domain\UserPermission\UserPermission;

interface UserPermissionRepositoryInterface {

    public function findByUserAndPermission(User $user, ApplicationPermission $applicationPermission): ?UserPermission;

    public function saveEntity(UserPermission $userPermission): UserPermission;

    public function getUserPermissionsByApplication(User $user, Application $application): GrantedPermissionsList;

}