<?php

namespace Core\Domain\UserPermission;

use Core\Domain\AbstractItemsList;

class GrantedPermissionsList extends AbstractItemsList {

    public function toArray(): array
    {
        $result = [];

        foreach ($this->container as $userPermissionItem) {

            /** @var UserPermission $userPermissionItem */
            $applicationPermission = $userPermissionItem->getApplicationPermission();
            $result[] = [
                'permissionName' => $applicationPermission->getPermissionName(),
                'permissionDescription' => $applicationPermission->getPermissionDescription(),
                'isGranted' => $userPermissionItem->isGranted()
            ];
        }

        return $result;
    }

}