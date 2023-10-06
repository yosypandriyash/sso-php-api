<?php

namespace App\Models;

use App\Models\Base\ApplicationPermissionsBaseModel;



class ApplicationPermissionsModel extends ApplicationPermissionsBaseModel {

    public function getCountMatchesByApplicationIdAndPermissionName(string $applicationId, string $permissionName): int
    {
        $items = $this->query(
            '
                SELECT 
                   count(id) as result
                FROM application_permissions
                WHERE
                    application_id = ' . $applicationId .  ' AND permission_name = "' . $permissionName . '"'
            ,false);

        $items = reset($items);
        return (int) $items['result'];
    }
}
