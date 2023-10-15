<?php

namespace App\Models;

use App\Models\Base\UserApplicationPermissionsBaseModel;

class UserApplicationPermissionsModel extends UserApplicationPermissionsBaseModel {

    public function getOneByUserIdApplicationPermissionId(int $userId, int $applicationPermissionId): ?UserApplicationPermissionsModel
    {
        return $this->getFirst([
            'userId' => $userId,
            'applicationPermissionId' => $applicationPermissionId,
        ]);
    }

    public function getUserPermissionsByApplicationId(int $userId): array
    {
        return $this->getAll([
            'userId' => $userId,
            'isGranted' => true,
            'deletedAt' => null
        ]);
    }
}
